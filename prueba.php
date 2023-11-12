<!DOCTYPE html>
<html>
<head>
    <title>Ejemplo de PHP y Base de Datos</title>
</head>
<body>

<h1>Resultados desde la base de datos:</h1>

<?php
    $usuario = 'admin';
    $contrasena = 'push1234';
    $host = 'database-1.cgklsm5ek2li.us-east-2.rds.amazonaws.com'; // Reemplaza con la dirección del servidor Oracle
    $puerto = '1521'; // El puerto por defecto para Oracle es 1521
    $sid = 'ORCL'; // El SID de tu base de datos Oracle

    // Construye la cadena de conexión
    $tns = "(DESCRIPTION =
        (ADDRESS = (PROTOCOL = TCP)(HOST = " . $host . ")(PORT = " . $puerto . "))
        (CONNECT_DATA =
        (SID = " . $sid . ")
        )
    )";

    // Intentar la conexión
    $conn = oci_connect($usuario, $contrasena, $tns);

    if (!$conn) {
        $error = oci_error();
        die("Conexión fallida: " . $error['message']);
    } else {
        echo "Conexión exitosa a Oracle.";
        // Aquí podrías realizar consultas, operaciones, etc.
    }


    // Cerrar la conexión
    oci_close($conn);
?>


</body>
</html>