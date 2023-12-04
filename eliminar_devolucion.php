<?php
// eliminar_prestamo.php
include 'conexion.php';

// Verifica si se recibió el ID del préstamo
if (isset($_POST['idprestamo'])) {
    $idPrestamo = $_POST['idprestamo'];

    // Verifica si la conexión fue exitosa
    if (!$conn) {
        $error = oci_error();
        echo "Error de conexión: " . $error['message'];
    } else {
        
        $sqlEliminarPrestamo = "DELETE FROM PRESTAMO WHERE IDPRESTAMO = :idprestamo";
        $stmtEliminarPrestamo = oci_parse($conn, $sqlEliminarPrestamo);
        oci_bind_by_name($stmtEliminarPrestamo, ':idprestamo', $idPrestamo);
        $resultado = oci_execute($stmtEliminarPrestamo);

        if ($resultado) {
            header("Location: devoluciones.php?dev_eliminada=true");
            exit();
        } else {
            $error = oci_error($stmtEliminarPrestamo);
            echo "Error al intentar eliminar el préstamo: " . $error['message'];
        }

        
        oci_close($conn);
    }
} else {
    echo "ID de préstamo no proporcionado.";
}
?>


