<?php
include 'config.php';

// Verificar si se envió el formulario para insertar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'insert') {
            // Consulta SQL para insertar los datos
            $sql = "INSERT INTO datos_esp (valor_unico, fecha) VALUES (UUID(), NOW())";

            // Ejecutar la consulta
            if (mysqli_query($conexion, $sql)) {
                $_SESSION['mensaje'] = "Los datos se han insertado correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al insertar los datos: " . mysqli_error($conexion);
            }
        } elseif ($_POST['action'] == 'delete') {
            // Consulta SQL para eliminar todos los datos
            $sql = "DELETE FROM datos_esp";

            // Ejecutar la consulta
            if (mysqli_query($conexion, $sql)) {
                $_SESSION['mensaje'] = "Todos los datos han sido eliminados correctamente";
            } else {
                $_SESSION['mensaje'] = "Error al eliminar los datos: " . mysqli_error($conexion);
            }
        }
    }
}

// Cerrar la conexión
mysqli_close($conexion);

// Redirigir de vuelta a index.php
header('Location: index.php');
exit();
