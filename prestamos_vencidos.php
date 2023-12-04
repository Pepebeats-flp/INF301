<?php
session_start();

require_once 'conexion.php';

if (isset($_SESSION["usuario"])) {
    $usuario = $_SESSION["usuario"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerrar_sesion"])) {
    session_destroy();
    header("Location: index.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamos Vencidos</title>
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
                    echo "Administrativo(a): ", $usuario;
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
            <a href="indexadmin.php" class="btn btn-dark me-4" aria-current="page">Consultar Catalogo</a>
        </li>
        <li class="nav-item">
            <a href="fichas_usuario.php" class="btn btn-dark me-4">Fichas Usuarios</a>
        </li>
        <li class="nav-item">
            <a href="prestamos_vencidos.php" class="btn btn-dark">Prestamos vencidos</a>
        </li>
        </ul>

    </div> 
</nav>

<br>

<?php 

if (isset($_GET["devuelto"]) && $_GET["devuelto"] == "true") {
    echo '<div class="alert alert-success mt-3 m-5 text-center" role="alert">
            Devolucion registrada exitosamente
        </div>';
}

if (isset($_GET["dev_eliminada"]) && $_GET["dev_eliminada"] == "true") {
    echo '<div class="alert alert-success mt-3 m-5 text-center" role="alert">
            Registro eliminado exitosamente
        </div>';
}

?>

<?php

require "conexion.php";

// Realiza la consulta para obtener los datos de la tabla PRESTAMO
$sqlConsultaPrestamo = "SELECT 
    P.IDPRESTAMO,
    P.TIPO_PRESTAMO,
    P.FECHA_PRESTAMO,
    P.FECHA_DEVOLUCION,
    P.HORA_DEVOLUCION,
    P.HORA_PRESTAMO,
    P.FECHA_DEVOLUCION_REAL,
    P.HORA_DEVOLUCION_REAL,
    P.IDUSUARIO
FROM 
    PRESTAMO P
JOIN 
    EJEMPLAR E ON P.IDEJEMPLAR = E.IDEJEMPLAR
JOIN 
    DOCUMENTO D ON E.IDDOCUMENTO = D.IDENTIFICADOR
ORDER BY 
    P.IDPRESTAMO"; 

$stmtConsultaPrestamo = oci_parse($conn, $sqlConsultaPrestamo);
oci_execute($stmtConsultaPrestamo);

echo '<div class="container shadow-sm rounded p-2 mt-2">';
echo '<h2>Prestamos vencidos </h2>';

echo '<div class="p-1 mb-3">';
echo '<table class="table table-striped">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">Prestamo</th>';
echo '<th scope="col">Tipo de Prestamo</th>';
echo '<th scope="col">RUT</th>'; 
echo '<th scope="col">Fecha Prestamo</th>';
echo '<th scope="col">Fecha Devolucion</th>';
echo '<th scope="col">Estado</th>';
echo '<th scope="col">Devuelto el</th>';
echo '<th scope="col">Sancion</th>'; 
echo '<th scope="col">Detalles</th>';
echo '<th scope="col">Eliminar</th>'; 
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Variable para mantener el último IDPRESTAMO registrado
$ultimoIdPrestamo = null;

// Itera sobre los resultados y muestra solo las filas en las que el estado sea "Atrasado" y devueltoEl sea null
while ($fila = oci_fetch_assoc($stmtConsultaPrestamo)) {
    if ($fila['IDPRESTAMO'] != $ultimoIdPrestamo) {
        $fechaActual = new DateTime(); 
        $fechaDevolucion = DateTime::createFromFormat('d/m/y', $fila['FECHA_DEVOLUCION']);  // Fecha de devolución

        $estado = ($fechaDevolucion >= $fechaActual)
            ? 'A tiempo'
            : 'Atrasado';

        if ($estado === 'Atrasado' && $fila['HORA_DEVOLUCION_REAL'] === null) {
            $sqlObtenerRUT = "SELECT RUT FROM USUARIO WHERE IDENTIFICADOR = :idusuario";
            $stmtObtenerRUT = oci_parse($conn, $sqlObtenerRUT);
            oci_bind_by_name($stmtObtenerRUT, ':idusuario', $fila['IDUSUARIO']);
            oci_execute($stmtObtenerRUT);
            $rutUsuario = null;

            while ($filaRUT = oci_fetch_assoc($stmtObtenerRUT)) {
                $rutUsuario = $filaRUT['RUT'];
                break; 
            }

            $devueltoEl = ($fila['HORA_DEVOLUCION_REAL'] === null) ? "No Devuelto" : $fila['HORA_DEVOLUCION_REAL'];

            // Convierte las fechas a objetos DateTime
            $fechaDevolucion = DateTime::createFromFormat('d/m/Y', $fila['FECHA_DEVOLUCION']);
            $fechaDevolucionReal = $fila['FECHA_DEVOLUCION_REAL']
                ? DateTime::createFromFormat('d/m/Y', $fila['FECHA_DEVOLUCION_REAL'])
                : null;

            // Verifica si las fechas se pudieron convertir correctamente
            if ($fechaDevolucion && ($fechaDevolucionReal || $fechaDevolucionReal === null)) {

                $diferenciaDias = $fechaDevolucionReal !== null ? $fechaDevolucionReal->diff($fechaDevolucion)->days : 0;

                // Calcula la sanción en semanas solo si el estado no es 'A tiempo'
                $sancionSemanas = ($fila['FECHA_DEVOLUCION'] > $fila['FECHA_DEVOLUCION_REAL'] && $estado == 'Atrasado')
                    ? floor($diferenciaDias / 7 + 1)
                    : 0;

                $sancion = ($devueltoEl === "No Devuelto" || $fila['FECHA_DEVOLUCION'] < $fila['FECHA_DEVOLUCION_REAL'])
                    ? '-' 
                    : ($sancionSemanas > 0 ? $sancionSemanas . ' semana(s)' : '');
            } else {
                echo 'Error al convertir las fechas a objetos DateTime.';
            }

            echo '<tr>';
            echo "<td>{$fila['IDPRESTAMO']}</td>";
            echo "<td>{$fila['TIPO_PRESTAMO']}</td>";
            echo "<td>{$rutUsuario}</td>"; 
            echo "<td>{$fila['HORA_PRESTAMO']}</td>";
            echo "<td>{$fila['HORA_DEVOLUCION']}</td>";
            echo "<td>{$estado}</td>";
            echo "<td>{$devueltoEl}</td>";
            echo "<td>{$sancion}</td>"; 
            echo "<td>
                    <form method='post' action='detalles_devolucion_admin.php'>
                        <input type='hidden' name='idprestamo' value='{$fila['IDPRESTAMO']}'>
                        <button type='submit' class='btn btn-dark'>Detalles</button>
                    </form>
                </td>";
            echo "<td>";
            
            echo "<form method='post' action='' onsubmit='return confirm(\"¿Enviar notificacion?\");'>
                        <input type='hidden' name='' value=''>
                        <button type='submit' class='btn btn-primary'>Notificar</button>
                        </form>";
            echo "</td>";

            echo '</tr>';
        }

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