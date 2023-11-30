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

$identificador = $_GET['id'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar ficha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="catalogo.css">
    <script src="https://kit.fontawesome.com/a4490af95b.js" crossorigin="anonymous"></script>
</head>

<!-- Body Responsivo para usuarios y bibliotecarios -->
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
                <a href="fichas_usuario.php" class="btn btn-dark me-4">Fichas Usuario</a>
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

    <div class="container mt-5">
        <h2>Modificar Usuario</h2>
        
        <form action="procesar_mod_ficha.php" method="post">
            
            <!-- Agrega el campo oculto para almacenar el ID -->
            <input type="hidden" name="id" value="<?php echo $identificador; ?>">

            <div class="form-group mt-2">
                <label for="nombres">Nombres:</label>
                <input type="text" class="form-control" name="nombres"  >
            </div>

            <br>

            <div class="form-group mt-2">
                <label for="apellidos">Apellidos:</label>
                <input type="text" class="form-control" name="apellidos"  >
            </div>

            <br>

            <div class="form-group mt-2">
                <label for="rut">Rut:</label>
                <input type="text" class="form-control" name="rut"  >
            </div>

            <br>

            <div class="form-group mt-2">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" name="direccion" >
            </div>

            <br>

            <div class="form-group mt-2">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" >
            </div>

            <br>

            <!-- Resto de los campos del formulario -->

            <div style="text-align: left;">
                <!-- Cambia el texto del botón para reflejar la acción de modificación -->
                <button type="submit" class="btn btn-dark">Modificar</button>
                <a href="ficha_individual.php?id=<?php echo $identificador; ?>" class="btn btn-dark">Cancelar</a>
            </div>
        </form>
    </div>

    

</body>

</html>