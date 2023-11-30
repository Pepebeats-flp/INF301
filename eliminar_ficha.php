<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'conexion.php';

// Verificar si se recibió el identificador del usuario
if (isset($_GET['id'])) {
    $identificador = $_GET['id'];

    // Preparar la consulta SQL de eliminación
    $sql = "DELETE FROM Usuario WHERE IDENTIFICADOR = :IDENTIFICADOR";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':IDENTIFICADOR', $identificador);

    // Ejecutar la consulta
    if (oci_execute($stmt)) {
        // Éxito al eliminar el usuario
        header("Location: fichas_usuario.php?ficha_eliminada=true");
        exit();
    } else {
        // Error al eliminar el usuario
        header("Location: fichas_usuario.php?success=false&error=" . oci_error($conn));
        exit();
    }
} else {
    // No se proporcionó el identificador del usuario
    echo "Identificador de usuario no proporcionado";
}
?>

