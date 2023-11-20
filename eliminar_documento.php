<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'conexion.php';

// Verificar si se ha enviado un formulario para eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    // Recoger el ID desde el formulario
    $id_a_eliminar = $_POST["id"];

    // Sentencia SQL para eliminar el registro
    $sql = "DELETE FROM documento WHERE identificador = :id";

    // Preparar la sentencia
    $stmt = oci_parse($conn, $sql);

    // Bind de los parámetros
    oci_bind_by_name($stmt, ':id', $id_a_eliminar);

    // Ejecutar la sentencia
    if (oci_execute($stmt)) {
        header("Location: indexbiblio.php?eliminado=true");  // Redirigir a la página principal después de eliminar
        exit();
    } else {
        echo "Error al eliminar el registro: " . oci_error($conn);
    }
}
?>


