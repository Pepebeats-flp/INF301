<?php
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = $_POST['name'];
    $apellido = $_POST['lastname'];
    $correo = $_POST['email'];
    $password = $_POST['password'];
    $rut = $_POST['rut'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Insertar datos en la tabla Usuario
    $sql1 = "INSERT INTO Usuario (RUT, Nombres, Apellidos, Direccion, Telefono_Activo)
    VALUES ('$rut', '$nombre', '$apellido', '$direccion', '$telefono')";

    // Obten la clave original desde la variable $password
    $claveOriginal = $password;

    // Cifra la clave utilizando password_hash
    $claveCifrada = password_hash($claveOriginal, PASSWORD_DEFAULT);

    // ... Resto de tu código ...

    $sql2 = "INSERT INTO Cuentas_Usuario (RUT, Correo, Clave)
            VALUES ('$rut', '$correo', '$claveCifrada')";

    $statement1 = oci_parse($conn, $sql1);
    $statement2 = oci_parse($conn, $sql2); // Corregir aquí

    // Verificar si el usuario ya existe
    $sql_check = "SELECT COUNT(*) FROM Usuario WHERE RUT = '$rut'";
    $statement_check = oci_parse($conn, $sql_check);
    oci_execute($statement_check);
    $row = oci_fetch_assoc($statement_check);

    if ($row['COUNT(*)'] > 0) {
        // El usuario ya existe, puedes manejar esto según tus necesidades
        echo "El usuario con RUT $rut ya existe.";
    } else {
        // El usuario no existe, puedes proceder con la inserción
        $statement1 = oci_parse($conn, $sql1);
        $statement2 = oci_parse($conn, $sql2);

        if (oci_execute($statement1) && oci_execute($statement2)) {
            // Registro exitoso, redirigir a login.php
            
            header("Location: login.php?success=true");
            exit(); // Asegurarse de que no se ejecuten más instrucciones después de la redirección

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

    // Liberar recursos y cerrar la conexión
    oci_free_statement($statement1);
    oci_free_statement($statement2);
    oci_free_statement($statement_check); // Asegúrate de liberar el statement de verificación
    oci_close($conn);
}
?>
