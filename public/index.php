<?php
// Incluir el archivo de configuración
include '../includes/config.php';

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Consulta SQL para insertar los datos
    $sql = "INSERT INTO datos_esp (valor_unico, fecha) VALUES (UUID(), NOW())";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $sql)) {
        echo "Los datos se han insertado correctamente";
    } else {
        echo "Error al insertar los datos: " . mysqli_error($conexion);
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
    <style>
        /* ... (los estilos CSS se mantienen igual) ... */
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
    
    <h2>Insertar datos:</h2>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <input type="submit" value="Insertar datos">
    </form>
    <h2>Datos almacenados en la tabla datos_esp:</h2>
    <pre><?php echo json_encode($datos, JSON_PRETTY_PRINT); ?></pre>
</body>
</html>