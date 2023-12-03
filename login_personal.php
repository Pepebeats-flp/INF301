<?php
// Incluir la conexión a la base de datos
require_once 'conexion.php';

session_start();

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['usuario'])) {
    header("Location: index.php"); // Redirigir a la página de inicio
    exit();
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $clave = $_POST["contrasena"];

    // Consultar la base de datos para verificar las credenciales
    $consulta = "SELECT * FROM cuentas_personal WHERE usuario = :usuario AND contrasena = :contrasena";
    $stmt = oci_parse($conn, $consulta);

    oci_bind_by_name($stmt, ':usuario', $usuario);
    oci_bind_by_name($stmt, ':contrasena', $clave);

    oci_execute($stmt);

    if ($row = oci_fetch_assoc($stmt)) {
        // Usuario autenticado, iniciar sesión
        $_SESSION['usuario'] = $usuario;
    
        // Redirigir según el tipo de cuenta
        if ($row['TIPO_CUENTA'] == 'bibliotecario') {
            header("Location: indexbiblio.php"); 

        } elseif ($row['TIPO_CUENTA'] == 'admin') {
            header("Location: indexadmin.php"); 
            
        } else {
            
            header("Location: index.php"); // Redirigir a la página de inicio por defecto
        }
    
        exit();

    } else {
        $mensaje_error = "Credenciales incorrectas";
    }

    // Cerrar la conexión a la base de datos
    oci_free_statement($stmt);
    oci_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio de sesion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container mt-5 mb-5" style="margin: 0 auto; width: 90%;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="text-center">Ingreso personal</h3>
                    </div>
                    <div class="card-body ">
                        <?php if (isset($mensaje_error)) : ?>
                            <p><?php echo $mensaje_error; ?></p>
                        <?php endif; ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-3 mt-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="username" class="form-control" id="usuario" name="usuario" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="clave" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark">Iniciar sesión</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        <a href="login.php">Ingreso usuarios</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</body>

</html>