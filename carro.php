<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'conexion.php';

if (isset($_SESSION["usuario"])) {
    $correo = $_SESSION["usuario"];
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
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de catalogo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="catalogo.css">
    <script src="https://kit.fontawesome.com/a4490af95b.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-light bg-light shadow-sm">
        <div class="container">
            <span style="font-size: 20px;">
                <i class="fa-solid fa-user"></i> Carlos Lagos
            </span>
            <span style="cursor: pointer;font-size: 20px; text-align: right;">
                <i class="fa-solid fa-cart-shopping"></i>
            </span>
        </div> 
    </nav>

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
                        <th scope="col">Confirmar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ingeniería de Software</td>
                        <td>Roger S. Pressman</td>
                        <td>4° Edición</td>
                        <td>2000</td>
                        <td>Libro Técnico</td>
                        <td>Ingeniería Informatica</td>
                        <td>3</td>
                        <td>
                            <input type="checkbox">
                        </td>
                    </tr>
                    <tr>
                        <td>Ingeniería de Software</td>
                        <td>Roger S. Pressman</td>
                        <td>4° Edición</td>
                        <td>2000</td>
                        <td>Libro Técnico</td>
                        <td>Ingeniería Informatica</td>
                        <td>3</td>
                        <td>
                            <input type="checkbox">
                        </td>
                    </tr>
                    <tr>
                        <td>Ingeniería de Software</td>
                        <td>Roger S. Pressman</td>
                        <td>4° Edición</td>
                        <td>2000</td>
                        <td>Libro Técnico</td>
                        <td>Ingeniería Informatica</td>
                        <td>3</td>
                        <td>
                            <input type="checkbox">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="text-align: right;">
            <a href="index.php" class="btn btn-dark">Volver</a>
            <button class="btn btn-dark">Enviar Solicitud</button>
        </div>
    </div>
</body>
</html>