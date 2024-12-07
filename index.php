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
            // Consulta SQL para insertar los datos
            $sql = "INSERT INTO datos_esp (valor_unico, fecha) VALUES (UUID(), NOW())";

            // Ejecutar la consulta
            if (mysqli_query($conexion, $sql)) {
                echo json_encode(["success" => true, "message" => "Los datos se han insertado correctamente"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al insertar los datos: " . mysqli_error($conexion)]);
            }
        } elseif ($data['action'] == 'delete') {
            // Consulta SQL para eliminar todos los datos
            $sql = "DELETE FROM datos_esp";

            // Ejecutar la consulta
            if (mysqli_query($conexion, $sql)) {
                echo json_encode(["success" => true, "message" => "Todos los datos han sido eliminados correctamente"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al eliminar los datos: " . mysqli_error($conexion)]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Acción no reconocida"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No se especificó ninguna acción"]);
    }
}


// Consulta SQL para obtener los datos
$sql = "SELECT * FROM datos_esp";
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
    <title>Aplicación de Arduino ESP8266 D1</title>
</head>

<body>
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

    <h2>Datos almacenados en la tabla datos_esp:</h2>
    <pre><?php echo json_encode($datos, JSON_PRETTY_PRINT); ?></pre>
</body>

</html>