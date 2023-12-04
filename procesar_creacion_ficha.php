<?php
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $rut = $_POST["rut"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];

    $sql = "INSERT INTO Usuario (Nombres, Apellidos, Rut, Direccion, Telefono_Activo) VALUES (:nombres, :apellidos, :rut, :direccion, :telefono)";

    $stmt = oci_parse($conn, $sql);

    // Vincular parámetros
    oci_bind_by_name($stmt, ':nombres', $nombres);
    oci_bind_by_name($stmt, ':apellidos', $apellidos);
    oci_bind_by_name($stmt, ':rut', $rut);
    oci_bind_by_name($stmt, ':direccion', $direccion);
    oci_bind_by_name($stmt, ':telefono', $telefono);

    if (oci_execute($stmt)) {
        // Éxito al insertar el usuario
        header("Location: fichas_usuario.php?ficha_creada=true"); // Redirigir a donde desees después de la inserción
        exit();
    } else {
        // Error al insertar el usuario
        echo "Error al insertar el usuario: " . oci_error($conn);
    }
} else {
    // Redirigir si el formulario no ha sido enviado
    header("Location: fichas_usuario.php");
    exit();
}
?>
