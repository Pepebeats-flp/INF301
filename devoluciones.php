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
    <title>Devoluciones</title>
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

require "conexion.php";

// Realiza la consulta para obtener los datos de la tabla PRESTAMO
$sqlConsultaPrestamo = "SELECT 
    P.IDPRESTAMO,
    P.TIPO_PRESTAMO,
    P.FECHA_PRESTAMO,
    P.FECHA_DEVOLUCION,
    P.HORA_DEVOLUCION,
    P.HORA_PRESTAMO
FROM 
    PRESTAMO P
JOIN 
    EJEMPLAR E ON P.IDEJEMPLAR = E.IDEJEMPLAR
JOIN 
    DOCUMENTO D ON E.IDDOCUMENTO = D.IDENTIFICADOR
ORDER BY 
    P.IDPRESTAMO"; // Ordena por IDPRESTAMO para agrupar resultados por ID

$stmtConsultaPrestamo = oci_parse($conn, $sqlConsultaPrestamo);
oci_execute($stmtConsultaPrestamo);

echo '<div class="container shadow-sm rounded p-2 mt-2">';
echo '<h2>Prestamos activos </h2>';

echo '<div class="p-1 mb-3">';
echo '<table class="table table-striped">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">Préstamo</th>';
echo '<th scope="col">Tipo de Préstamo</th>';
echo '<th scope="col">Prestamo</th>';
echo '<th scope="col">Devolucion</th>';
echo '<th scope="col">Estado</th>';
echo '<th scope="col">Detalles</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Variable para mantener el último IDPRESTAMO registrado
$ultimoIdPrestamo = null;

// Itera sobre los resultados y muestra cada fila
while ($fila = oci_fetch_assoc($stmtConsultaPrestamo)) {
    // Si el IDPRESTAMO actual es diferente al último registrado, imprime una nueva fila
    if ($fila['IDPRESTAMO'] != $ultimoIdPrestamo) {
        $fechaActual = strtotime(date('Y-m-d'));
        $fechaDevolucion = date('Y-m-d', strtotime($fila['FECHA_DEVOLUCION']));

        $estado = ($fechaDevolucion >= $fechaActual)
            ? 'A tiempo'
            : 'Atrasado';


        echo '<tr>';
        echo "<td>{$fila['IDPRESTAMO']}</td>";
        echo "<td>{$fila['TIPO_PRESTAMO']}</td>";
        echo "<td>{$fila['HORA_PRESTAMO']}</td>";
        echo "<td>{$fila['HORA_DEVOLUCION']}</td>";
        echo "<td>{$estado}</td>";
        echo "<td>
                <form method='post' action='detalles_devolucion.php'>
                    <input type='hidden' name='idprestamo' value='{$fila['IDPRESTAMO']}'>
                    <button type='submit' class='btn btn-dark'>Detalles</button>
                </form>
            </td>";
        echo '</tr>';

        // Actualiza el último IDPRESTAMO registrado
        $ultimoIdPrestamo = $fila['IDPRESTAMO'];
    }
}

echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';

?>




</body>
</html>