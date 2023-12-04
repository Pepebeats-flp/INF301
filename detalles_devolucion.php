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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles devolucion</title>
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
// Verifica si se envió el formulario y se proporcionó el IDPRESTAMO
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idprestamo"])) {
    $idPrestamo = $_POST["idprestamo"];

    
    $sqlDetallesPrestamo = "SELECT 
    IDPRESTAMO, 
    TIPO_PRESTAMO, 
    FECHA_PRESTAMO, 
    FECHA_DEVOLUCION,
    HORA_DEVOLUCION,
    FECHA_DEVOLUCION_REAL,
    HORA_DEVOLUCION_REAL
    FROM 
    PRESTAMO
    WHERE 
    IDPRESTAMO = :idprestamo
    AND 
    ROWNUM = 1"; 
    $stmtDetallesPrestamo = oci_parse($conn, $sqlDetallesPrestamo);
    oci_bind_by_name($stmtDetallesPrestamo, ':idprestamo', $idPrestamo);
    oci_execute($stmtDetallesPrestamo);

    // Muestra la tabla con los detalles del préstamo
    echo '<div class="container shadow-sm rounded p-2 mt-2">';
    echo '<h2>Detalles del Préstamo</h2>';
    echo '<div class="p-1 mb-3">';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">IDPRESTAMO</th>';
    echo '<th scope="col">Tipo de Préstamo</th>';
    echo '<th scope="col">Prestamo</th>';
    echo '<th scope="col">Devolucion</th>';
    echo '<th scope="col">Estado</th>'; 
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Muestra los detalles del préstamo en la tabla
    while ($filaDetallesPrestamo = oci_fetch_assoc($stmtDetallesPrestamo)) {
        // Calcula el estado del préstamo
        $fechaActual = date('Y/m/d', strtotime(date('Y-m-d')));
        $fechaDevolucion = date('Y/d/m', strtotime($filaDetallesPrestamo['FECHA_DEVOLUCION']));

        $estado = ($fechaDevolucion >= $fechaActual)
            ? 'A tiempo'
            : 'Atrasado';
        
        echo '<tr>';
        echo "<td>{$filaDetallesPrestamo['IDPRESTAMO']}</td>";
        echo "<td>{$filaDetallesPrestamo['TIPO_PRESTAMO']}</td>";
        echo "<td>{$filaDetallesPrestamo['FECHA_PRESTAMO']}</td>";
        echo "<td>{$filaDetallesPrestamo['FECHA_DEVOLUCION']}</td>";
        echo "<td>{$estado}</td>"; 
        echo '</tr>';

        $fechaDevolucionReal = $filaDetallesPrestamo['FECHA_DEVOLUCION_REAL'];
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    echo '</div>';


    $sqlDocumentosPrestamo = "SELECT D.TITULO, D.AUTOR, D.EDICION, D.EDITORIAL, D.ANIO, D.TIPO, D.CATEGORIA, D.CANTIDAD
                              FROM PRESTAMO P
                              JOIN EJEMPLAR E ON P.IDEJEMPLAR = E.IDEJEMPLAR
                              JOIN DOCUMENTO D ON E.IDDOCUMENTO = D.IDENTIFICADOR
                              WHERE P.IDPRESTAMO = :idprestamo";
    $stmtDocumentosPrestamo = oci_parse($conn, $sqlDocumentosPrestamo);
    oci_bind_by_name($stmtDocumentosPrestamo, ':idprestamo', $idPrestamo);
    oci_execute($stmtDocumentosPrestamo);

    echo '<div class="container shadow-sm rounded p-2 mt-2">';
    echo '<h2>Documentos Relacionados al Préstamo</h2>';
    echo '<div class="p-1 mb-3">';
    echo '<table class="table table-striped">';
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
    echo '<tbody>';

    // Muestra los documentos relacionados al préstamo en la tabla
    while ($filaDocumentosPrestamo = oci_fetch_assoc($stmtDocumentosPrestamo)) {
        echo '<tr>';
        echo "<td>{$filaDocumentosPrestamo['TITULO']}</td>";
        echo "<td>{$filaDocumentosPrestamo['AUTOR']}</td>";
        echo "<td>{$filaDocumentosPrestamo['EDICION']}</td>";
        echo "<td>{$filaDocumentosPrestamo['EDITORIAL']}</td>";
        echo "<td>{$filaDocumentosPrestamo['ANIO']}</td>";
        echo "<td>{$filaDocumentosPrestamo['TIPO']}</td>";
        echo "<td>{$filaDocumentosPrestamo['CATEGORIA']}</td>";
        echo "<td>{$filaDocumentosPrestamo['CANTIDAD']}</td>";
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

    
    echo '<form method="post" action="procesar_devolucion.php">';
    echo '<input type="hidden" name="idprestamo" value="' . $idPrestamo . '">';
    echo '<button type="submit" class="btn btn-dark" ' . ($fechaDevolucionReal !== null ? 'disabled' : '') . '>Procesar devolucion</button>';
    echo '<a href="devoluciones.php" class="btn btn-dark" style="margin-left: 10px;">Volver</a>';
    echo '</form>';

    echo '</div>';
    echo '</div>';
} else {
    echo '<div class="alert alert-danger" role="alert">ID de préstamo no proporcionado.</div>';
}

?>

</body>
</html>