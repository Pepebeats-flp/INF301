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

        <span style="font-size: 20px;" class="d-flex align-items-center">
            <i class="fa-solid fa-user"></i> 

            <?php 
                if (isset($usuario)) {
                    echo $usuario;
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
                        <th scope="col">Modificar</th>
                        <th scope="col">Eliminar</th>
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
                        echo "<td>
                                <form method='post' action='modificar_documento.php'>
                                    <input type='hidden' name='id' value='{$fila['IDENTIFICADOR']}'>
                                    <button type='submit' class='btn btn-danger'>Modificar</button>
                                </form>
                            </td>";
                        echo "<td>
                                <form method='post' action='eliminar_documento.php'>
                                    <input type='hidden' name='id' value='{$fila['IDENTIFICADOR']}'>
                                    <button type='submit' class='btn btn-danger'>Eliminar</button>
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div style="text-align: right;">
            <a href="indexbiblio.php" class="btn btn-outline-dark">Volver</a>
        </div>
    </div>
</body>
</html>