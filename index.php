<?php
session_start();

// Incluir la conexión a la base de datos
require_once 'conexion.php';

if (isset($_SESSION["usuario"])) {
    $correo = $_SESSION["usuario"];
} else {
    // El correo no está definido en la sesión.
    // Puede que haya un problema en la autenticación o redirección.
    header("Location: login.php");
    exit();
}

// Cerrar sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerrar_sesion"])) {
    session_destroy();
    header("Location: login.php"); // Redirigir al inicio de sesión después de cerrar la sesión
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de catálogo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="catalogo.css">
    <script src="https://kit.fontawesome.com/a4490af95b.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-light bg-light shadow-sm">
        <div class="container">
            <span style="font-size: 20px;">
                <i class="fa-solid fa-user"></i> <?php echo $correo; ?>
            </span>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <button type="submit" class="btn btn-danger" name="cerrar_sesion">Cerrar Sesión</button>
            </form>
            <span style="cursor: pointer;font-size: 20px; text-align: right;">
                <a href="carro.php" style="text-decoration: none; color: black;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            </span>
        </div> 
    </nav>
    
    <div class="container shadow-sm rounded p-2 mt-2">
        <h2>Búsqueda de documentos:</h2>
        <form action="buscar_documentos.php" method="get" class="p-3" id="filtroForm">
            <div class="form-group row mb-3">
                <label for="document_type" class="col-sm-3 col-form-label">Tipo de documento: </label>
                <div class="col-sm-9">
                    <select id="document_type" name="document_type" class="form-select">
                        <option>Revista</option>
                        <option>Articulo</option>
                        <option>Libro</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="category" class="col-sm-3 col-form-label">Categoría: </label>
                <div class="col-sm-9">
                    <select id="category" name="category" class="form-select">
                        <option>Tecnologia</option>
                        <option>Ciencia</option>
                        <option>Arte</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="title" class="col-sm-3 col-form-label">Titulo: </label>
                <div class="col-sm-9">
                    <input type="text" class="form form-control" id="title" name="title" placeholder="Ingresa el titulo...">
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="author" class="col-sm-3 col-form-label">Autor: </label>
                <div class="col-sm-9">
                    <input type="text" class="form form-control" id="author" name="author" placeholder="Ingresa el autor...">
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="topic" class="col-sm-3 col-form-label">Tema: </label>
                <div class="col-sm-9">
                    <input type="text" class="form form-control" id="topic" name="topic" placeholder="Ingresa el tema...">
                </div>
            </div>
            <div style="text-align: right;">
                <button class="btn btn-outline-dark">Volver</button>
                <button class="btn btn-dark" id="aplicarFiltroBtn">Aplicar filtro</button>
            </div>
        </form>
    </div>

    <?php
    // Redirigir a buscar_documentos.php con los parámetros del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $url = "buscar_documentos.php?";
        $url .= "document_type=" . (isset($_POST['document_type']) ? urlencode($_POST['document_type']) : "") . "&";
        $url .= "category=" . (isset($_POST['category']) ? urlencode($_POST['category']) : "") . "&";
        $url .= "title=" . (isset($_POST['title']) ? urlencode($_POST['title']) : "") . "&";
        $url .= "author=" . (isset($_POST['author']) ? urlencode($_POST['author']) : "") . "&";
        $url .= "topic=" . (isset($_POST['topic']) ? urlencode($_POST['topic']) : "");

        header("Location: $url");
        exit();
    }
    ?>

</body>
</html>