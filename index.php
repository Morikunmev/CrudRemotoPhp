

<?php
// ESTE ES EL INDEX
// Incluir el archivo de configuración
include 'config.php';

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
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .info {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        form {
            margin: 20px 0;
        }
        input[type="submit"] {
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
        }
        .delete-button {
            background-color: #ff4444;
            color: white;
            border: none;
            border-radius: 3px;
        }
        pre {
            background-color: #f8f8f8;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>Trabajo 4 Proyecto Arduino ESP8266 D1</h1>
    
    <div class="info">
        <p>Integrantes:</p>
        <ul>
            <li>Richard Rocuant</li>
            <li>Pablo Oyarzun</li>
        </ul>
    </div>
    
    <h2>Acciones:</h2>
    <form method="POST" action="insertar.php" style="display: inline;">
        <input type="hidden" name="action" value="insert">
        <input type="submit" value="Insertar datos">
    </form>

    <form method="POST" action="insertar.php" style="display: inline;"
          onsubmit="return confirm('¿Está seguro de que desea eliminar todos los datos?');">
        <input type="hidden" name="action" value="delete">
        <input type="submit" value="Eliminar todos los datos" class="delete-button">
    </form>

    <h2>Datos almacenados en la tabla datos_esp:</h2>
    <pre><?php echo json_encode($datos, JSON_PRETTY_PRINT); ?></pre>
</body>
</html>