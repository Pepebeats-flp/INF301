<?php
// Incluir la conexión a la base de datos
session_start();
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

$document_type = isset($_GET['document_type']) ? $_GET['document_type'] : null;
$category = isset($_GET['category']) ? $_GET['category'] : null;
$title = isset($_GET['title']) ? $_GET['title'] : null;
$author = isset($_GET['author']) ? $_GET['author'] : null;
$topic = isset($_GET['topic']) ? $_GET['topic'] : null;

// Construir la consulta SQL con filtros
$sql = "SELECT * FROM Documento WHERE 1=1";

if (!empty($document_type)) {
    $sql .= " AND TIPO = '$document_type'";
}

if (!empty($category)) {
    $sql .= " AND CATEGORIA = '$category'";
}

if (!empty($title)) {
    $sql .= " AND TITULO LIKE '%$title%'";
}

if (!empty($author)) {
    $sql .= " AND AUTOR LIKE '%$author%'";
}

if (!empty($topic)) {
    $sql .= " AND TEMA LIKE '%$topic%'";
}

// Ejecutar la consulta
$resultado = oci_parse($conn, $sql);
oci_execute($resultado);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de búsqueda</title>
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
            <a href="#" class="btn btn-dark me-4" aria-current="page">Consultar Catalogo</a>
        </li>
        <li class="nav-item">
            <a href="#" class="btn btn-dark me-4">Registrar ficha usuario</a>
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

    <div class="container shadow-sm rounded p-2 mt-2">
        <h2>Documentos encontrados:</h2>
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
                        <th scope="col">Cantidad</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Iterar sobre los resultados y mostrar cada fila
                    while ($fila = oci_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>{$fila['TITULO']}</td>";
                        echo "<td>{$fila['AUTOR']}</td>";
                        echo "<td>{$fila['EDICION']}</td>";
                        echo "<td>{$fila['ANIO']}</td>";
                        echo "<td>{$fila['TIPO']}</td>";
                        echo "<td>{$fila['CATEGORIA']}</td>";
                        echo "<td>3</td>";
                        
                    }
                    ?>

                    
                </tbody>
            </table>
        </div>
        <div style="text-align: right;">
            <a href="indexadmin.php" class="btn btn-outline-dark">Volver</a>
        </div>
    </div>
</body>
</html>