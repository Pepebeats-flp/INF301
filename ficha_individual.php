

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
    header("Location: index.php"); 
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha</title>
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
            </form>

            <ul class="nav">
            <li class="nav-item">
                <a href="indexadmin.php" class="btn btn-dark me-4" aria-current="page">Consultar Catalogo</a>
            </li>
            <li class="nav-item">
                <a href="fichas_usuario.php" class="btn btn-dark me-4">Fichas Usuario</a>
            </li>
            <li class="nav-item">
                <a href="prestamos_vencidos.php" class="btn btn-dark">Prestamos vencidos</a>
            </li>
            </ul>

        </div> 
    </nav>

<br>

<?php 
if (isset($_GET["ficha_modificada"]) && $_GET["ficha_modificada"] == "true") {
    echo '<div class="alert alert-success mt-3 m-5 text-center" role="alert">
            La ficha ha sido modificada con exito.
        </div>';
}

?>

<?php 
if (isset($_GET['success'])) {
    $success = $_GET['success'];

    if ($success == '2') {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              Usuario modificado con éxito
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}

?>

<div class="container rounded p-2 mt-2">

    <h2 >Detalles del usuario</h2>

</div>


<div class="container">
        <?php
        // Obtener el identificador único de la persona desde la URL
        $identificador = $_GET['id'];

        // Realizar la consulta a la base de datos para obtener los detalles de la persona
        $sql = "SELECT * FROM Usuario WHERE IDENTIFICADOR = :IDENTIFICADOR";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':IDENTIFICADOR', $identificador);
        oci_execute($stmt);

        // Obtener los detalles de la persona
        if ($fila = oci_fetch_assoc($stmt)) {
            ?>
            
            <br>
            <div class="card mx-auto" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS90qkiaP9m61Utx5xa86xmQhvRmoH1auaZ_YuH6fPNhg&s" class="card-img" alt="Avatar del usuario">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Nombre completo: <?php echo $fila['NOMBRES'] . ' ' . $fila['APELLIDOS']; ?></h5>
                            <p class="card-text"><strong>RUT:</strong> <?php echo $fila['RUT']; ?></p>
                            <p class="card-text"><strong>Direccion:</strong> <?php echo $fila['DIRECCION']; ?></p>
                            <p class="card-text"><strong>Telefono activo:</strong> <?php echo $fila['TELEFONO_ACTIVO']; ?></p>
                            
                            
                        </div>
                    </div>
                </div>

                
            </div>

            <br>

            <div style="text-align: center;">
                <a href="modificar_ficha.php?id=<?php echo $identificador; ?>" class="btn btn-dark">Modificar ficha</a>
                <a href="javascript:void(0);" onclick="confirmarEliminacion(<?php echo $identificador; ?>)" class="btn btn-danger">Eliminar ficha</a>
                <a href="fichas_usuario.php" class="btn btn-dark">Volver</a>
            </div>

            
            <?php
        } else {
            // No se encontraron detalles para el identificador proporcionado
            echo 'Usuario no encontrado.';
        }
        ?>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


    <script>
        function confirmarEliminacion(identificador) {
            var confirmacion = confirm("¿Estás seguro de eliminar este usuario?");

            if (confirmacion) {
                window.location.href = "eliminar_ficha.php?id=" + identificador;
            }
        }
    </script>

</body>

</html>