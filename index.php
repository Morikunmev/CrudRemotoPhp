<?php
// Incluir el archivo de configuración
include 'config.php';

// Verificar si se envió el formulario para insertar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leer el contenido de la solicitud
    $jsonData = file_get_contents("php://input");
    
    // Decodificar JSON a un array asociativo
    $data = json_decode($jsonData, true);
    
    // Verificar si la acción está definida
    if (isset($data['action'])) {
        if ($data['action'] == 'insert') {
            // Obtener la temperatura del JSON, si existe
            $temperatura = isset($data['temperatura']) ? $data['temperatura'] : null;
            
            // Consulta SQL para insertar los datos incluyendo temperatura
            $sql = "INSERT INTO datos_esp (valor_unico, fecha, temperatura) VALUES (UUID(), NOW(), ?)";
            
            // Preparar la consulta
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "d", $temperatura);
            
            // Ejecutar la consulta preparada
            if (mysqli_stmt_execute($stmt)) {
                echo json_encode([
                    "success" => true, 
                    "message" => "Los datos se han insertado correctamente",
                    "temperatura" => $temperatura
                ]);
            } else {
                echo json_encode([
                    "success" => false, 
                    "message" => "Error al insertar los datos: " . mysqli_error($conexion)
                ]);
            }
            mysqli_stmt_close($stmt);
            
        } elseif ($data['action'] == 'delete') {
            // Consulta SQL para eliminar todos los datos
            $sql = "DELETE FROM datos_esp";
            
            // Ejecutar la consulta
            if (mysqli_query($conexion, $sql)) {
                echo json_encode([
                    "success" => true, 
                    "message" => "Todos los datos han sido eliminados correctamente"
                ]);
            } else {
                echo json_encode([
                    "success" => false, 
                    "message" => "Error al eliminar los datos: " . mysqli_error($conexion)
                ]);
            }
        } else {
            echo json_encode([
                "success" => false, 
                "message" => "Acción no reconocida"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false, 
            "message" => "No se especificó ninguna acción"
        ]);
    }
}

// Consulta SQL para obtener los datos
$sql = "SELECT id, valor_unico, fecha, temperatura FROM datos_esp ORDER BY fecha DESC";
// Ejecutar la consulta
$result = mysqli_query($conexion, $sql);
// Crear un array para almacenar los datos
$datos = array();

// Recorrer los resultados y agregarlos al array
while ($row = mysqli_fetch_assoc($result)) {
    $datos[] = $row;
}

// Cerrar la conexión
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monitoreo de Temperatura ESP8266</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .delete-button {
            background-color: #ff4444;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .actions-container {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h1>Sistema de Monitoreo de Temperatura</h1>
    
    <div class="actions-container">
        <h2>Acciones:</h2>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" style="display: inline;">
            <input type="hidden" name="action" value="insert">
            <input type="submit" value="Insertar datos">
        </form>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" style="display: inline;"
            onsubmit="return confirm('¿Está seguro de que desea eliminar todos los datos?');">
            <input type="hidden" name="action" value="delete">
            <input type="submit" value="Eliminar todos los datos" class="delete-button">
        </form>
    </div>

    <h2>Registros de Temperatura:</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Valor Único</th>
                <th>Fecha y Hora</th>
                <th>Temperatura (°C)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $dato): ?>
            <tr>
                <td><?php echo htmlspecialchars($dato['id']); ?></td>
                <td><?php echo htmlspecialchars($dato['valor_unico']); ?></td>
                <td><?php echo htmlspecialchars($dato['fecha']); ?></td>
                <td><?php echo isset($dato['temperatura']) ? 
                    htmlspecialchars(number_format($dato['temperatura'], 2)) . ' °C' : 
                    'No disponible'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Datos en formato JSON:</h3>
    <pre><?php echo json_encode($datos, JSON_PRETTY_PRINT); ?></pre>
</body>
</html>