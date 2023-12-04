<?php
session_start();
require_once 'conexion.php';

if (isset($_SESSION["correo"])) {
    $correo = $_SESSION["correo"];
}

// Cerrar sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerrar_sesion"])) {
    session_destroy();
    header("Location: index.php"); // Redirigir al inicio de sesión después de cerrar la sesión
    exit();
}

if (!isset($_SESSION["carrito"]) || $_SESSION["carrito"] === null) {
    $_SESSION["carrito"] = array();
}

$document_type = isset($_GET['document_type']) ? $_GET['document_type'] : null;
$category = isset($_GET['category']) ? $_GET['category'] : null;
$title = isset($_GET['title']) ? $_GET['title'] : null;
$author = isset($_GET['author']) ? $_GET['author'] : null;
$topic = isset($_GET['topic']) ? $_GET['topic'] : null;

$search = isset($_POST['search']) ? $_POST['search'] : null;

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
    $sql .= " AND ANIO LIKE '%$topic%'";
}

if (!empty($search)) {
    $sql .= " AND TITULO LIKE '%$search%'";
}

$resultado = oci_parse($conn, $sql);
oci_execute($resultado);

// Obtener el identificador del documento que se está agregando al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_al_carrito"])) {
    $documento_id = $_POST["agregar_al_carrito"];
    echo "Documento ID: " . $documento_id . "<br>";

    // Realizar una consulta para obtener los detalles del documento
    $sql = "SELECT * FROM Documento WHERE IDENTIFICADOR = :documento_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":documento_id", $documento_id);

    if (!$stmt) {
        $e = oci_error($conn); 
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_execute($stmt);
    $documento = oci_fetch_assoc($stmt);
    $_SESSION['carrito'][] = $documento;

    header("Location: carro.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de busqueda</title>
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
                    
                    if (isset($correo)) {
                        echo "Usuario(a): ", $correo;
                ?>
                        
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <button type="submit" class="btn btn-danger" name="cerrar_sesion">Cerrar Sesión</button>
                        </form>

                <?php 

                    } else {
                        
                        echo '<a href="login.php" class="btn btn-outline-dark" style="margin-left: 10px;">Iniciar Sesión</a>';
                        echo '<a href="register.php" class="btn btn-outline-dark" style="margin-left: 10px;">Registrarse</a>';
                        echo '<div class="alert alert-danger shadow-sm rounded p-2 mt-2" role="alert" style="font-size: 16px;">
                        Debes iniciar sesión o registrarte para poder solicitar documentos
                        </div>';
                        
                        
                        
                    }
                
                ?>
            </span>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                
            </form>
            <span style="cursor: pointer;font-size: 20px; text-align: right;">
                <a href="carro.php" style="text-decoration: none; color: black;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            </span>
        </div> 
    </nav>

    <div class="container shadow-sm rounded p-2 mt-2">
        <h2>Documentos encontrados:</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="search">Buscar por título:</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Ingrese el título" value="<?php echo htmlspecialchars($search); ?>">
            </div>
        </form>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="p-1 mb-3">
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
                        <th scope="col">Agregar</th>
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
                        echo "<td>{$fila['CANTIDAD']}</td>"; 
                        echo "<td><button type='submit' class='btn btn-dark' name='agregar_al_carrito' value='{$fila['IDENTIFICADOR']}'>Agregar a Carrito</button></td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </form>
        <div style="text-align: right;">
            <a href="index.php" class="btn btn-outline-dark">Volver</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#search').on('input', function() {
                var searchValue = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>',
                    data: { search: searchValue },
                    success: function(response) {
                        $('#resultTable').html(response);
                    }
                });
                
            });
        });
    </script>
</body>
</html>
