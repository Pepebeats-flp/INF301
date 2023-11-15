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
    <title>Consulta de catálogo</title>
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

<ul class="nav justify-content-center">
  <li class="nav-item">
    <a href="#" class="btn btn-dark me-4" aria-current="page">Administrar Catalogo</a>
  </li>
  <li class="nav-item">
    <a href="#" class="btn btn-dark me-4">Revisar solicitudes</a>
  </li>
  <li class="nav-item">
    <a href="#" class="btn btn-dark me-4">Registrar prestamo</a>
  </li>
  <li class="nav-item">
    <a href="#" class="btn btn-dark">Devoluciones</a>
  </li>
</ul>

    

    <div class="container shadow-sm rounded p-2 mt-2">
        <h2>Búsqueda de documentos:</h2>
        <form action="buscar_documentos_biblio.php" method="get" class="p-3" id="filtroForm">
            <div class="form-group row mb-3">
                <label for="document_type" class="col-sm-3 col-form-label">Tipo de documento: </label>
                <div class="col-sm-9">
                    <select id="document_type" name="document_type" class="form-select">
                        <option value="" disabled selected>Elegir tipo</option>
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
                        <option value="" disabled selected>Elegir categoría</option>
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
                <button class="btn btn-dark" id="aplicarFiltroBtn">Aplicar filtro</button>
            </div>
        </form>
    </div>

    <?php
    // Realizar la consulta a la base de datos
    $sql = "SELECT * FROM Documento";
    $resultado = oci_parse($conn, $sql);
    oci_execute($resultado);
    ?>

    <div class="container shadow-sm rounded p-2 mt-2">
        <h2>Todos los documentos: </h2>

        <a href="#" class="btn btn-dark">Agregar documento</a>

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

                    }
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>

    <?php
    // Redirigir a buscar_documentos_biblio.php con los parámetros del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $url = "buscar_documentos_biblio.php?";
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