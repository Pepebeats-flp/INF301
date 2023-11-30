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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear ficha</title>
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
            <a href="fichas_usuario.php" class="btn btn-dark me-4">Fichas Usuarios</a>
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
    <h2>Crear ficha</h2>
    
    <form action="procesar_creacion_ficha.php" method="post">
        <div class="form-group mt-2">
            <label for="nombres">Nombres:</label>
            <input type="text" class="form-control" name="nombres" required>
        </div>

        <br>

        <div class="form-group mt-2">
            <label for="apellidos">Apellidos:</label>
            <input type="text" class="form-control" name="apellidos" required>
        </div>

        <br>

        <div class="form-group mt-2">
            <label for="rut">Rut:</label>
            <input type="text" class="form-control" name="rut" required>
        </div>

        <br>

        <div class="form-group mt-2">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" name="direccion">
        </div>

        <br>

        <div class="form-group mt-2">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" name="telefono">
        </div>

        <br>

        <div style="text-align: left;">
            <button type="submit" class="btn btn-dark">Crear</button>
            <a href="fichas_usuario.php" class="btn btn-outline-dark">Volver</a>
        </div>
    </form>
</div>

</body>

</html>