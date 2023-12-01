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
// Realizar la consulta a la base de datos para obtener los datos de las solicitudes de préstamo
$sql = "SELECT S.IDSOLICITUD, S.IDUSUARIO, U.NOMBRES, U.RUT, S.FECHA_SOLICITUD, S.HORA_SOLICITUD
        FROM SOLICITUD_PRESTAMO S
        JOIN Usuario U ON S.IDUSUARIO = U.IDENTIFICADOR";

$resultado = oci_parse($conn, $sql);
oci_execute($resultado);
?>

<div class="container shadow-sm rounded p-2 mt-2">
    <h2>Administración de solicitudes de préstamo</h2>

    <div class="p-1 mb-3" style="overflow: scroll; max-height:300px;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID Solicitud</th>
                    <th scope="col">ID Usuario</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">RUT</th>
                    <th scope="col">Fecha Solicitud</th>
                    <th scope="col">Hora Solicitud</th>
                    <th scope="col">Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Iterar sobre los resultados y mostrar cada fila
                while ($fila = oci_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>{$fila['IDSOLICITUD']}</td>";
                    echo "<td>{$fila['IDUSUARIO']}</td>";
                    echo "<td>{$fila['NOMBRES']}</td>";
                    echo "<td>{$fila['RUT']}</td>";
                    echo "<td>{$fila['FECHA_SOLICITUD']}</td>";
                    echo "<td>{$fila['HORA_SOLICITUD']}</td>";
                    echo "<td>
                            <form method='post' action='detalles_solicitud.php'>
                            <input type='hidden' name='idsolicitud' value='{$fila['IDSOLICITUD']}'>
                            <button type='submit' class='btn btn-dark'>Detalles</button>
                            </form>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

    
            
        

    

</body>
</html>