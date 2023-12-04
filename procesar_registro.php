<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['name'];
    $apellido = $_POST['lastname'];
    $correo = $_POST['email'];
    $password = $_POST['password'];
    $rut = $_POST['rut'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $sql1 = "INSERT INTO Usuario (RUT, Nombres, Apellidos, Direccion, Telefono_Activo)
    VALUES ('$rut', '$nombre', '$apellido', '$direccion', '$telefono')";

    $claveOriginal = $password;
    $claveCifrada = password_hash($claveOriginal, PASSWORD_DEFAULT);


    $sql2 = "INSERT INTO Cuentas_Usuario (RUT, Correo, Clave)
            VALUES ('$rut', '$correo', '$claveCifrada')";

    $statement1 = oci_parse($conn, $sql1);
    $statement2 = oci_parse($conn, $sql2); 

    // Verificar si el usuario ya existe
    $sql_check = "SELECT COUNT(*) FROM Usuario WHERE RUT = '$rut'";
    $statement_check = oci_parse($conn, $sql_check);
    oci_execute($statement_check);
    $row = oci_fetch_assoc($statement_check);

    if ($row['COUNT(*)'] > 0) {
        echo "El usuario con RUT $rut ya existe.";
    } else {
        $statement1 = oci_parse($conn, $sql1);
        $statement2 = oci_parse($conn, $sql2);

        if (oci_execute($statement1) && oci_execute($statement2)) {
            // Registro exitoso, redirigir a login.php
            
            header("Location: login.php?success=true");
            exit(); 

        } else {
            $error1 = oci_error($statement1);
            $error2 = oci_error($statement2);

            echo "Error al registrar los datos:<br>";

            if ($error1) {
                echo "Statement 1: " . $error1['message'] . "<br>";
            }

            if ($error2) {
                echo "Statement 2: " . $error2['message'] . "<br>";
            }
        }
    }

    oci_free_statement($statement1);
    oci_free_statement($statement2);
    oci_free_statement($statement_check); 
    oci_close($conn);
}
?>
