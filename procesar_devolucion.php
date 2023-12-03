<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idprestamo"])) {
    
    $idPrestamo = $_POST["idprestamo"];
    $sqlActualizarDevolucion = "UPDATE PRESTAMO SET FECHA_DEVOLUCION_REAL = CURRENT_TIMESTAMP, HORA_DEVOLUCION_REAL = CURRENT_TIMESTAMP WHERE IDPRESTAMO = :idprestamo";
    $stmtActualizarDevolucion = oci_parse($conn, $sqlActualizarDevolucion);
    oci_bind_by_name($stmtActualizarDevolucion, ':idprestamo', $idPrestamo);

    if (oci_execute($stmtActualizarDevolucion)) {
        
        echo '<div class="alert alert-success" role="alert">Devolución procesada exitosamente.</div>';
        header('Location: devoluciones.php?devuelto=true');
        exit();
    } else {
        // Error al actualizar la devolución
        echo '<div class="alert alert-danger" role="alert">Error al procesar la devolución.</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">ID de préstamo no proporcionado.</div>';
}

// Cierra la conexión a la base de datos
oci_close($conn);
?>

