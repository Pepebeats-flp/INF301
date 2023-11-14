<?php
$usuario_bd = 'SYSTEM'; // Reemplaza con el nombre de usuario de tu base de datos
$clave_bd = 'diego1234'; // Reemplaza con la contraseña de tu base de datos
$host_bd = 'localhost'; // Reemplaza con la dirección del servidor Oracle
$puerto_bd = '1521'; // El puerto por defecto para Oracle es 1521
$sid_bd = 'xe'; // Reemplaza con el SID de tu base de datos Oracle

// Construye la cadena de conexión
$tns = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = " . $host_bd . ")(PORT = " . $puerto_bd . "))
    (CONNECT_DATA =
      (SID = " . $sid_bd . ")
    )
)";

// Intentar la conexión
$conn = oci_connect($usuario_bd, $clave_bd, $tns);

if (!$conn) {
    $error = oci_error();
    die("Conexión fallida: " . $error['message']);
}
?>