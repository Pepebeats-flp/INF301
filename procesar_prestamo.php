<?php
require "conexion.php";

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idsolicitud"])) {
    // Obtén el ID de la solicitud desde el formulario
    $idSolicitud = $_POST["idsolicitud"];

    // Realiza la consulta para obtener el IDUSUARIO desde SOLICITUD_PRESTAMO
    $sqlObtenerIdUsuario = "SELECT IDUSUARIO FROM SOLICITUD_PRESTAMO WHERE IDSOLICITUD = :idsolicitud";
    $stmtObtenerIdUsuario = oci_parse($conn, $sqlObtenerIdUsuario);
    oci_bind_by_name($stmtObtenerIdUsuario, ':idsolicitud', $idSolicitud);
    oci_execute($stmtObtenerIdUsuario);

    // Obtiene el IDUSUARIO
    if ($filaIdUsuario = oci_fetch_assoc($stmtObtenerIdUsuario)) {
        $idUsuario = $filaIdUsuario['IDUSUARIO'];

        // Realiza la consulta para obtener todos los IDEJEMPLAR desde DETALLE_SOLICITUD_PRESTAMO
        $sqlDetalles = "SELECT IDEJEMPLAR FROM DETALLE_SOLICITUD_PRESTAMO WHERE IDSOLICITUD = :idsolicitud";
        $stmtDetalles = oci_parse($conn, $sqlDetalles);
        oci_bind_by_name($stmtDetalles, ':idsolicitud', $idSolicitud);
        oci_execute($stmtDetalles);

        // Genera el IDPRESTAMO utilizando la secuencia directamente
        $sqlNextVal = "SELECT SEQ_PRESTAMO.NEXTVAL FROM DUAL";
        $idPrestamoStmt = oci_parse($conn, $sqlNextVal);
        oci_execute($idPrestamoStmt);
        oci_fetch($idPrestamoStmt);
        $idPrestamoValue = oci_result($idPrestamoStmt, 1);

        // Itera sobre los IDEJEMPLAR encontrados
        while ($filaDetalles = oci_fetch_assoc($stmtDetalles)) {
            $idejemplar = $filaDetalles['IDEJEMPLAR'];

            // Inserta una fila en la tabla PRESTAMO con el mismo IDPRESTAMO y el IDUSUARIO obtenido
            $sqlInsertPrestamo = "INSERT INTO PRESTAMO (IDPRESTAMO, IDUSUARIO, TIPO_PRESTAMO, IDEJEMPLAR, FECHA_PRESTAMO, HORA_PRESTAMO, FECHA_DEVOLUCION, HORA_DEVOLUCION) 
                VALUES (:idprestamo, :idusuario, 'Documento', :idejemplar, CURRENT_DATE, CURRENT_TIMESTAMP, CURRENT_DATE + INTERVAL '7' DAY, CURRENT_TIMESTAMP + INTERVAL '7' DAY)";
            $stmtInsertPrestamo = oci_parse($conn, $sqlInsertPrestamo);

            oci_bind_by_name($stmtInsertPrestamo, ':idprestamo', $idPrestamoValue);
            oci_bind_by_name($stmtInsertPrestamo, ':idusuario', $idUsuario);
            oci_bind_by_name($stmtInsertPrestamo, ':idejemplar', $idejemplar);
            oci_execute($stmtInsertPrestamo);

            // Disminuir en una unidad el valor de CANTIDAD en la tabla Documentos
            $sqlUpdateCantidad = "UPDATE Documento SET CANTIDAD = CANTIDAD - 1 WHERE IDENTIFICADOR = (SELECT IDDOCUMENTO FROM Ejemplar WHERE IDEJEMPLAR = :idejemplar)";
            $stmtUpdateCantidad = oci_parse($conn, $sqlUpdateCantidad);
            oci_bind_by_name($stmtUpdateCantidad, ':idejemplar', $idejemplar);
            oci_execute($stmtUpdateCantidad);
        }

        // Continuación de tu código...

        $sqlDeleteDetalles = "DELETE FROM DETALLE_SOLICITUD_PRESTAMO WHERE IDSOLICITUD = :idsolicitud";
        $stmtDeleteDetalles = oci_parse($conn, $sqlDeleteDetalles);
        oci_bind_by_name($stmtDeleteDetalles, ':idsolicitud', $idSolicitud);
        oci_execute($stmtDeleteDetalles);

        // Elimina la solicitud de las tablas SOLICITUD_PRESTAMO y DETALLE_SOLICITUD_PRESTAMO
        $sqlDeleteSolicitud = "DELETE FROM SOLICITUD_PRESTAMO WHERE IDSOLICITUD = :idsolicitud";
        $stmtDeleteSolicitud = oci_parse($conn, $sqlDeleteSolicitud);
        oci_bind_by_name($stmtDeleteSolicitud, ':idsolicitud', $idSolicitud);
        oci_execute($stmtDeleteSolicitud);

        header("Location: solicitudes_prestamo.php?prestamo_creado=true");
        exit();
    } else {
        echo '<div class="alert alert-danger" role="alert">No se pudo obtener el IDUSUARIO.</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">ID de solicitud no proporcionado.</div>';
}
?>


