<?php
$usuario_bd = 'admin'; 
$clave_bd = 'push1234';
$host_bd = 'database-1.cgklsm5ek2li.us-east-2.rds.amazonaws.com'; 
$puerto_bd = '1521'; 
$sid_bd = 'ORCL'; 


$tns = "(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = " . $host_bd . ")(PORT = " . $puerto_bd . "))
    (CONNECT_DATA =
      (SID = " . $sid_bd . ")
    )
)";


$conn = oci_connect($usuario_bd, $clave_bd, $tns);

if (!$conn) {
    $error = oci_error();
    die("Conexión fallida: " . $error['message']);
}
?>