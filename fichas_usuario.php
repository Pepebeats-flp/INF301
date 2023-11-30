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
    <title>Fichas usuarios</title>
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
            <!-- Otro formulario u otros elementos según sea necesario -->
        </form>

        <ul class="nav">
        <li class="nav-item">
            <a href="indexadmin.php" class="btn btn-dark me-4" aria-current="page">Consultar Catalogo</a>
        </li>
        <li class="nav-item">
            <a href="fichas_usuario.php" class="btn btn-dark me-4">Registrar ficha usuario</a>
        </li>
        <li class="nav-item">
            <a href="#" class="btn btn-dark me-4">Revisar solicitudes prestamo</a>
        </li>
        <li class="nav-item">
            <a href="#" class="btn btn-dark">Prestamos vencidos</a>
        </li>
        </ul>

    </div> 
</nav>

<br>

<?php
if (isset($_GET["ficha_eliminada"]) && $_GET["ficha_eliminada"] == "true") {
    echo '<div class="alert alert-success mt-3 m-5 text-center" role="alert">
            La ficha ha sido eliminada con exito.
        </div>';
}

if (isset($_GET["ficha_creada"]) && $_GET["ficha_creada"] == "true") {
    echo '<div class="alert alert-success mt-3 m-5 text-center" role="alert">
            La ficha ha sido creada con exito.
        </div>';
}

?>

<div class="container rounded p-2 mt-2">

    <h2 >Fichas registradas</h2>

    <div style="text-align: left;">
        <a href="agregar_ficha.php" class="btn btn-dark">Crear ficha</a>
    </div>

</div>


<?php
    // Incluir la conexión a la base de datos
    require_once 'conexion.php';

    // Realizar la consulta a la base de datos
    $sql = "SELECT * FROM Usuario";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);

    // Comienzo del contenedor
    echo '<div class="container shadow-sm rounded p-2 mt-2">';

    // Verificar si la consulta fue exitosa
    if ($stmt) {
        // Iterar sobre los resultados
        while ($fila = oci_fetch_assoc($stmt)) {
            // Extraer datos del array asociativo
            $rut = $fila['RUT'];
            $nombres = $fila['NOMBRES'];
            $apellidos = $fila['APELLIDOS'];
            $direccion = $fila['DIRECCION'];
            $telefono = $fila['TELEFONO_ACTIVO'];
            $identificador = $fila['IDENTIFICADOR'];
        
            // Mostrar la tarjeta con los datos
            echo '<div class="card" style="width: 100%;">
                    <h5 class="card-header">Ficha personal</h5>
                    <div class="card-body">
                        <h5 class="card-title">Nombre: ' . $nombres . ' ' . $apellidos . '</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">RUT: ' . $rut . '</h6>
                        <a href="ficha_individual.php?id=' . $identificador . '" class="btn btn-dark me-4" aria-current="page">Detalles</a>
                        
                    </div>
                </div>
                <br>';

                
        }
    } else {
        // Mensaje en caso de error en la consulta
        echo 'Error en la consulta a la base de datos';
    }

    // Fin del contenedor
    echo '</div>';
?>

</body>

</html>