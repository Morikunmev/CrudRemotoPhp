<?php
// Incluir el archivo de configuración (asegúrate de que la ruta es correcta)
include 'config.php';

// Consulta SQL para insertar los datos
$sql = "INSERT INTO datos_esp (valor_unico, fecha) VALUES (UUID(), NOW())";

// Ejecutar la consulta
$result = mysqli_query($conexion, $sql);

// Verificar el resultado de la consulta
if ($result) {
    echo "Los datos se han insertado correctamente";
} else {
    echo "Error al insertar los datos: " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
