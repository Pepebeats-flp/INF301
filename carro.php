<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'conexion.php';

if (isset($_SESSION["correo"])) {
    $correo = $_SESSION["correo"];
} else {
    // La sesión no está iniciada, redirigir a la página de inicio de sesión
    header("Location: login.php");
    // Terminar el script para evitar que se ejecute más código
    exit();
}

// Cerrar sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerrar_sesion"])) {
    session_destroy();
    header("Location: index.php"); // Redirigir al inicio de sesión después de cerrar la sesión
    exit();
}

// Verificar si la variable de sesión "carrito" está definida y no es null
if (isset($_SESSION["carrito"]) && is_array($_SESSION["carrito"])) {
    $carrito = $_SESSION["carrito"];
} else {
    // Si el carrito no está definido o es null, muestra un mensaje indicando que está vacío
    echo "El carrito está vacío.";
}

// Procesar la solicitud de eliminar item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_item"])) {
    $idItemEliminar = $_POST["eliminar_item"];

    // Buscar y eliminar el item del carrito
    foreach ($carrito as $key => $item) {
        if ($item['IDENTIFICADOR'] == $idItemEliminar) {
            unset($carrito[$key]);
            break;
        }
    }

    // Actualizar la variable de sesión con el carrito modificado
    $_SESSION["carrito"] = $carrito;
}

// Procesar la solicitud de enviar la solicitud
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar_solicitud"])) {
    // Obtener el id del usuario desde la base de datos
    $correoUsuario = $_SESSION['correo'];
    $sqlIdUsuario = "SELECT u.IDENTIFICADOR FROM Usuario u JOIN cuentas_Usuario cu ON u.rut = cu.rut WHERE cu.correo = :correo";
    $stmtIdUsuario = oci_parse($conn, $sqlIdUsuario);
    oci_bind_by_name($stmtIdUsuario, ":correo", $correoUsuario);
    oci_execute($stmtIdUsuario);

    if ($filaIdUsuario = oci_fetch_assoc($stmtIdUsuario)) {
        $idUsuario = $filaIdUsuario['IDENTIFICADOR'];

        // Obtener fecha y hora actuales
        $fechaSolicitud = date('Y-m-d');
        $horaSolicitud = date('H:i:s');

        // Insertar en la tabla SolicitudPrestamo
        $sqlInsertSolicitud = "INSERT INTO Solicitud_Prestamo (idUsuario, fecha_Solicitud, hora_Solicitud) VALUES (:idUsuario, TO_DATE(:fecha_Solicitud, 'YYYY-MM-DD'), TO_TIMESTAMP(:hora_Solicitud, 'HH24:MI:SS')) RETURNING idSolicitud INTO :idSolicitud";
        $stmtInsertSolicitud = oci_parse($conn, $sqlInsertSolicitud);
        oci_bind_by_name($stmtInsertSolicitud, ":idUsuario", $idUsuario);
        oci_bind_by_name($stmtInsertSolicitud, ":fecha_Solicitud", $fechaSolicitud);
        oci_bind_by_name($stmtInsertSolicitud, ":hora_Solicitud", $horaSolicitud);
        oci_bind_by_name($stmtInsertSolicitud, ":idSolicitud", $idSolicitud, 10); // El tercer parámetro es la longitud máxima del campo

        // Ejecutar la inserción
        oci_execute($stmtInsertSolicitud);

        // Obtener el idSolicitud generado por la inserción
        $idSolicitud = $idSolicitud ?? null; // Si no se asigna, establecerlo en null

        // Insertar en la tabla DetalleSolicitudPrestamo
        foreach ($carrito as $item) {
            // Obtener idEjemplar de la tabla Ejemplar usando el IDENTIFICADOR del carrito
            $idDocumento = $item['IDENTIFICADOR'];
            $sqlObtenerIdEjemplar = "SELECT idEjemplar FROM Ejemplar WHERE idDocumento = :idDocumento AND Estado = 'Bueno'";
            $stmtObtenerIdEjemplar = oci_parse($conn, $sqlObtenerIdEjemplar);
            oci_bind_by_name($stmtObtenerIdEjemplar, ":idDocumento", $idDocumento);
            oci_execute($stmtObtenerIdEjemplar);
            $idEjemplar = oci_fetch_assoc($stmtObtenerIdEjemplar)['IDEJEMPLAR'];

            // Liberar recursos de la consulta de idEjemplar
            oci_free_statement($stmtObtenerIdEjemplar);

            // Insertar en la tabla DetalleSolicitudPrestamo
            $sqlInsertDetalle = "INSERT INTO Detalle_Solicitud_Prestamo (idSolicitud, idEjemplar) VALUES (:idSolicitud, :idEjemplar)";
            $stmtInsertDetalle = oci_parse($conn, $sqlInsertDetalle);
            oci_bind_by_name($stmtInsertDetalle, ":idSolicitud", $idSolicitud);
            oci_bind_by_name($stmtInsertDetalle, ":idEjemplar", $idEjemplar);

            // Ejecutar la inserción
            $resultInsertDetalle = oci_execute($stmtInsertDetalle);

            if (!$resultInsertDetalle) {
                $errorDetalle = oci_error($stmtInsertDetalle);
                echo "Error en la inserción de DetalleSolicitudPrestamo: " . $errorDetalle['message'];
            }

            // Liberar recursos de la consulta de detalle
            oci_free_statement($stmtInsertDetalle);
        }

        // Limpia los recursos de la consulta
        oci_free_statement($stmtIdUsuario);
        oci_free_statement($stmtInsertSolicitud);

        // Limpiar el carrito después de procesar la solicitud
        $_SESSION["carrito"] = array();

    } else {
        // No se encontró el usuario, maneja la situación según tus necesidades
        echo "No se encontró el usuario.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="catalogo.css">
    <script src="https://kit.fontawesome.com/a4490af95b.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- ... (código del encabezado) ... -->

    <div class="container shadow-sm rounded p-2 mt-5">
        <h2>Carro: </h2>
        <div class="p-1 mb-3" style="overflow: scroll; max-height:300px;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Título</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Edición</th>
                        <th scope="col">Año</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">#</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($_SESSION['carrito'])) {
                    foreach ($_SESSION['carrito'] as $item) {
                        echo "<tr>";
                        echo "<td>{$item['TITULO']}</td>";
                        echo "<td>{$item['AUTOR']}</td>";
                        echo "<td>{$item['EDICION']}</td>";
                        echo "<td>{$item['ANIO']}</td>";
                        echo "<td>{$item['TIPO']}</td>";
                        echo "<td>{$item['CATEGORIA']}</td>";
                        echo "<td>{$item['CANTIDAD']}</td>";
                        echo "<td><form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'><input type='hidden' name='eliminar_item' value='{$item['IDENTIFICADOR']}'><button type='submit' class='btn btn-danger btn-sm'>Eliminar</button></form></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>El carrito está vacío.</td></tr>";
                }
                ?>

                </tbody>
            </table>
        </div>
        <div style="text-align: right; margin: 1%;">
            <a href="index.php" class="btn btn-dark me-2">Volver</a>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" style="display: inline-block;">
                <button type="submit" class="btn btn-dark" name="enviar_solicitud">Enviar Solicitud</button>
            </form>
        </div>
    </div>
</body>
</html>
