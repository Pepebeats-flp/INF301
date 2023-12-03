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
    <title>Detalles solicitud</title>
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
            <a href="solicitudes_prestamo.php" class="btn btn-dark me-4">Solicitudes</a>
        </li>
        <li class="nav-item">
            <a href="devoluciones.php" class="btn btn-dark">Devoluciones</a>
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

    // Realiza la consulta para obtener todos los IDEJEMPLAR desde DETALLE_SOLICITUD_PRESTAMO
    $sqlDetalles = "SELECT IDEJEMPLAR FROM DETALLE_SOLICITUD_PRESTAMO WHERE IDSOLICITUD = :idsolicitud";
    $stmtDetalles = oci_parse($conn, $sqlDetalles);
    oci_bind_by_name($stmtDetalles, ':idsolicitud', $idSolicitud);
    oci_execute($stmtDetalles);

    // Verifica si se encontraron detalles
    if ($filaDetalles = oci_fetch_assoc($stmtDetalles)) {
        // Inicializa la tabla Bootstrap
        echo '<div class="container shadow-sm rounded p-2 mt-2">';
        echo '<h2>Detalles solicitud</h2>';
        echo '<div class="p-1 mb-3">';
        echo '<table class="table table-striped">';

        // Encabezado de la tabla
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Título</th>';
        echo '<th scope="col">Autor</th>';
        echo '<th scope="col">Edición</th>';
        echo '<th scope="col">Editorial</th>';
        echo '<th scope="col">Año</th>';
        echo '<th scope="col">Tipo</th>';
        echo '<th scope="col">Categoría</th>';
        echo '<th scope="col">Cantidad</th>';
        echo '</tr>';
        echo '</thead>';

        // Cuerpo de la tabla
        echo '<tbody>';

        // Itera sobre los IDEJEMPLAR encontrados
        do {
            $idejemplar = $filaDetalles['IDEJEMPLAR'];

            // Realiza la consulta para obtener los detalles del documento desde EJEMPLAR
            $sqlDocumento = "SELECT IDDOCUMENTO, TITULO, AUTOR, EDICION, EDITORIAL, ANIO, TIPO, CATEGORIA, CANTIDAD FROM EJEMPLAR
                JOIN DOCUMENTO ON EJEMPLAR.IDDOCUMENTO = DOCUMENTO.IDENTIFICADOR
                WHERE IDEJEMPLAR = :idejemplar";
            $stmtDocumento = oci_parse($conn, $sqlDocumento);
            oci_bind_by_name($stmtDocumento, ':idejemplar', $idejemplar);
            oci_execute($stmtDocumento);

            // Muestra los detalles del documento en la tabla Bootstrap
            while ($filaDocumento = oci_fetch_assoc($stmtDocumento)) {
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
            }
        } while ($filaDetalles = oci_fetch_assoc($stmtDetalles));

        // Cierra la tabla Bootstrap
        echo '</tbody>';
        echo '</table>';

        // Agrega el formulario con el botón para procesar el préstamo
        echo '<form method="post" action="procesar_prestamo.php">';
        echo '<input type="hidden" name="idsolicitud" value="' . $idSolicitud . '">';
        echo '<button type="submit" class="btn btn-dark">Procesar prestamo</button>';
        echo '<a href="solicitudes_prestamo.php" class="btn btn-dark" style="margin-left: 10px;">Cancelar</a>';
        echo '</form>';


        echo '</div>';
        echo '</div>';

    } else {
        echo '<div class="alert alert-warning" role="alert">No se encontraron documentos para la solicitud proporcionada.</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">ID de solicitud no proporcionado.</div>';
}
?>








    
            
        

    

</body>
</html>