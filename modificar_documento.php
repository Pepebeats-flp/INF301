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

// Obtener el ID del documento a modificar (asegúrate de recibirlo correctamente)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $documento_id = $_POST["id"];

    // Obtener los datos actuales del documento desde la base de datos
    $sql = "SELECT * FROM Documento WHERE Identificador = :id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':id', $documento_id);
    oci_execute($stmt);

    // Obtener los datos del documento
    $documento = oci_fetch_assoc($stmt);
    
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar documento</title>
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
        </div> 
    </nav>

    <div class="container mt-5">
        <h2>Modificar Documento</h2>
        
        <form action="procesar_mod_doc.php" method="post">
            <input type="hidden" name="id" value="<?php echo $documento_id; ?>">

            <div class="form-group mt-2">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" name="titulo"  >
            </div>

            <br>

            <div class="form-group mt-2">
                <label for="autor">Autor:</label>
                <input type="text" class="form-control" name="autor"  >
            </div>

            <br>

            <div class="form-group">
                <label for="edicion">Edición:</label>
                <input type="text" class="form-control" name="edicion">
            </div>

            <br>

            <div class="form-group mt-2">
                <label for="editorial">Editorial:</label>
                <input type="text" class="form-control" name="editorial">
            </div>

            <br>

            <div class="form-group mt-2">
                <label for="anio">Año:</label>
                <input type="number" class="form-control" name="anio">
            </div>

            <br>

            <div class="form-group mt-2">
                <label for="tipo">Tipo:</label>
                <select class="form-control" name="tipo">
                    <option value="" disabled selected >Elegir tipo</option>
                    <option value="Libro">Libro</option>
                    <option value="Revista">Revista</option>
                    <option value="Articulo">Articulo</option>
                </select>
            </div>

            <br>

            <div class="form-group mt-2">
                <label for="categoria">Categoría:</label>
                <select class="form-control" name="categoria">
                    <option value="" disabled selected>Elegir categoria</option>
                    <option value="Ciencia">Ciencia</option>
                    <option value="Tecnologia">Tecnología</option>
                    <option value="Arte">Arte</option>
                </select>
            </div>

            <br>

            <div class="form-group mt-2">
                <label for="cantidad">Cantidad:</label>
                <input type="number" class="form-control" name="cantidad">
            </div>

            <br>

        
            <div style="text-align: left;">
                <button type="submit" class="btn btn-dark">Modificar Documento</button>
                <a href="indexbiblio.php" class="btn btn-outline-dark">Volver</a>
            </div>
        </form>
    </div>
</body>

</html>
