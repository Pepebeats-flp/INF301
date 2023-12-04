<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'conexion.php';

// Verificar si se ha enviado un formulario para eliminar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    
    $id_a_eliminar = $_POST["id"];
    $sql = "DELETE FROM documento WHERE identificador = :id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':id', $id_a_eliminar);

    if (oci_execute($stmt)) {
        header("Location: indexbiblio.php?doc_eliminado=true");  // Redirigir a la página principal después de eliminar
        exit();
    } else {
        echo "Error al eliminar el registro: " . oci_error($conn);
    }
}
?>


