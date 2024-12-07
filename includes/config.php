<?php
// Datos de la conexión a Railway
$servername = "junction.proxy.rlwy.net";  // MySQL Host Name (Railway)
$username = "root";                       // MySQL User Name (Railway)
$password = "ZfiliSBjGHUnOXbVJvBETZRxRlxtGEFE";  // MySQL Password (Railway)
$dbname = "railway";                      // MySQL DB Name (Railway)
$port = 55607;                            // MySQL Port (Railway)

// Crear la conexión a Railway
$conexion = mysqli_connect($servername, $username, $password, $dbname, $port);

// Verificar la conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>