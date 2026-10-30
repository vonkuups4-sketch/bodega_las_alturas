<?php
$host = "localhost";
$usuario = "root";
$clave = "";
$bd = "bodega_las_alturas";

// Crea la conexion con los datos guardados
$conexion = new mysqli($host, $usuario, $clave, $bd);

// es para que por si la conexion falla, el die() detiene el programa y muestra el error
if ($conexion->connect_errno){
    die("Error de conexion: " . $conexion->connect_error);
}
// es para que las tildes, y las ñ se puedan guardar
$conexion->set_charset("utf8mb4");