<?php
// Incluir la conexión a la base de datos
session_start();
require_once 'conexion.php';

// Verificar si la variable de sesión "carrito" no está definida o es null
if (!isset($_SESSION["carrito"]) || $_SESSION["carrito"] === null) {
    // Inicializar la variable de sesión "carrito" como un array vacío
    $_SESSION["carrito"] = array();
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

// Obtener el identificador del documento que se está agregando al carrito
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["agregar_al_carrito"])) {
    $documento_id = $_POST["agregar_al_carrito"];
    echo "Documento ID: " . $documento_id . "<br>";

    // Realizar una consulta para obtener los detalles del documento
    $sql = "SELECT * FROM Documento WHERE IDENTIFICADOR = :documento_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":documento_id", $documento_id);

    // Verifica que la consulta se prepare correctamente
    if (!$stmt) {
        $e = oci_error($conn); // Para errores de OCI, no usamos oci_error()!
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_execute($stmt);

    // Obtener los detalles del documento
    $documento = oci_fetch_assoc($stmt);

    // Añadir el documento al carrito en la sesión
    $_SESSION['carrito'][] = $documento;

    // Redirigir a la página del carrito
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
                    
                    // Mostrar $correo solo si está definido
                    if (isset($_SESSION["correo"])) {
                        echo $_SESSION["correo"];
                ?>
                        
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <button type="submit" class="btn btn-danger" name="cerrar_sesion">Cerrar Sesión</button>
                        </form>

                <?php 

                    } else {
                        // Mostrar el botón "Iniciar Sesión" si el usuario no está autenticado
                        echo '<a href="login.php" class="btn btn-outline-dark">Iniciar Sesión</a>';
                        echo '<a href="register.php" class="btn btn-outline-dark">Registrarse</a>';
                        
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
    <!-- ... (código del encabezado) ... -->

    <div class="container shadow-sm rounded p-2 mt-2">
        <h2>Documentos encontrados:</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
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
                            echo "<td>{$fila['CANTIDAD']}</td>"; // Agregar el ID del documento
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
</body>
</html>
