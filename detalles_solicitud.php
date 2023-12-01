<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'conexion.php';

if (isset($_SESSION["usuario"])) {
    $usuario = $_SESSION["usuario"];
}

// Cerrar sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerrar_sesion"])) {
    session_destroy();
    header("Location: index.php"); // Redirigir al inicio de sesión después de cerrar la sesión
    exit();
}

// Verificar si se ha creado un documento
if (isset($_GET["documento_creado"]) && $_GET["documento_creado"] == 1) {
    $alert_message = "Documento creado con éxito";
    $alert_class = "alert-success"; // Puedes cambiar esto según el tipo de alerta que desees
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de prestamo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="catalogo.css">
    <script src="https://kit.fontawesome.com/a4490af95b.js" crossorigin="anonymous"></script>
</head>
<body>


<nav class="navbar navbar-light bg-light shadow-sm">
    <div class="container">

        <span style="font-size: 20px;">
            <i class="fa-solid fa-user"></i> 

            <?php 
                if (isset($usuario)) {
                    echo "Bibliotecario(a): ", $usuario;
            ?>
                    
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <button type="submit" class="btn btn-danger" name="cerrar_sesion">Cerrar Sesión</button>
                    </form>

            <?php 
                } else {
                    echo '<a href="login.php" class="btn btn-outline-dark">Iniciar Sesión</a>';
                    echo '<a href="register.php" class="btn btn-outline-dark">Registrarse</a>';
                }
            ?>
        </span>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Otro formulario u otros elementos según sea necesario -->
        </form>

        <ul class="nav">
        <li class="nav-item">
            <a href="indexbiblio.php" class="btn btn-dark me-4" aria-current="page">Administrar Catalogo</a>
        </li>
        <li class="nav-item">
            <a href="solicitudes_prestamo.php" class="btn btn-dark me-4">Revisar solicitudes</a>
        </li>
        <li class="nav-item">
            <a href="#" class="btn btn-dark me-4">Registrar prestamo</a>
        </li>
        <li class="nav-item">
            <a href="#" class="btn btn-dark">Devoluciones</a>
        </li>
        </ul>

    </div> 
</nav>

<br>


<?php
// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idsolicitud"])) {
    // Obtén el ID de la solicitud desde el formulario
    $idSolicitud = $_POST["idsolicitud"];

    // Realiza la consulta para obtener el IDEJEMPLAR desde DETALLE_SOLICITUD_PRESTAMO
    $sqlDetalles = "SELECT IDEJEMPLAR FROM DETALLE_SOLICITUD_PRESTAMO WHERE IDSOLICITUD = :idsolicitud";
    $stmtDetalles = oci_parse($conn, $sqlDetalles);
    oci_bind_by_name($stmtDetalles, ':idsolicitud', $idSolicitud);
    oci_execute($stmtDetalles);

    // Verifica si se encontraron detalles
    if ($filaDetalles = oci_fetch_assoc($stmtDetalles)) {
        $idejemplar = $filaDetalles['IDEJEMPLAR'];

        // Realiza la consulta para obtener el IDDOCUMENTO desde EJEMPLAR
        $sqlDocumento = "SELECT IDDOCUMENTO, TITULO, AUTOR, EDICION, EDITORIAL, ANIO, TIPO, CATEGORIA, CANTIDAD FROM EJEMPLAR
            JOIN DOCUMENTO ON EJEMPLAR.IDDOCUMENTO = DOCUMENTO.IDENTIFICADOR
            WHERE IDEJEMPLAR = :idejemplar";
        $stmtDocumento = oci_parse($conn, $sqlDocumento);
        oci_bind_by_name($stmtDocumento, ':idejemplar', $idejemplar);
        oci_execute($stmtDocumento);

        // Muestra los detalles del documento en una tabla Bootstrap
        echo '<div class="container mt-4">';
        echo '<h2>Detalles solicitud</h2>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        echo '<th>Título</th>';
        echo '<th>Autor</th>';
        echo '<th>Edición</th>';
        echo '<th>Editorial</th>';
        echo '<th>Año</th>';
        echo '<th>Tipo</th>';
        echo '<th>Categoría</th>';
        echo '<th>Cantidad</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Muestra los detalles del documento en la tabla
        if ($filaDocumento = oci_fetch_assoc($stmtDocumento)) {
            echo '<tr>';
            echo '<td>' . $filaDocumento['TITULO'] . '</td>';
            echo '<td>' . $filaDocumento['AUTOR'] . '</td>';
            echo '<td>' . $filaDocumento['EDICION'] . '</td>';
            echo '<td>' . $filaDocumento['EDITORIAL'] . '</td>';
            echo '<td>' . $filaDocumento['ANIO'] . '</td>';
            echo '<td>' . $filaDocumento['TIPO'] . '</td>';
            echo '<td>' . $filaDocumento['CATEGORIA'] . '</td>';
            echo '<td>' . $filaDocumento['CANTIDAD'] . '</td>';
            echo '</tr>';
        } else {
            echo '<tr><td colspan="8">No se encontraron detalles del documento.</td></tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="alert alert-warning" role="alert">No se encontró IDEJEMPLAR para la solicitud proporcionada.</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">ID de solicitud no proporcionado.</div>';
}
?>





    
            
        

    

</body>
</html>