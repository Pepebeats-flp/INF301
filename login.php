<?php
session_start(); // Inicia la sesión (si aún no se ha iniciado)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    $usuario = htmlentities($usuario); // Evitar inyección de HTML
    $contrasena = htmlentities($contrasena); // Evitar inyección de HTML

    // Verificar la conexión a la base de datos (usando tu código existente)
    $usuario_bd = 'admin';  // Reemplaza con tus credenciales
    $contrasena_bd = 'push1234';  // Reemplaza con tus credenciales
    $host_bd = 'database-1.cgklsm5ek2li.us-east-2.rds.amazonaws.com';  // Reemplaza con la dirección de tu servidor Oracle
    $puerto_bd = '1521';  // Reemplaza con el puerto de tu servidor Oracle
    $sid_bd = 'ORCL';  // Reemplaza con el SID de tu base de datos Oracle

    $tns = "(DESCRIPTION =
        (ADDRESS = (PROTOCOL = TCP)(HOST = " . $host_bd . ")(PORT = " . $puerto_bd . "))
        (CONNECT_DATA =
        (SID = " . $sid_bd . ")
        )
    )";

    $conn = oci_connect($usuario_bd, $contrasena_bd, $tns);

    if (!$conn) {
        $error = oci_error();
        die("Conexión fallida: " . $error['message']);
    }

    // Consulta preparada para verificar las credenciales del usuario
    $sql = "SELECT nombre_usuario FROM usuarios WHERE nombre_usuario = :usuario AND contrasena = :contrasena";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":usuario", $usuario);
    oci_bind_by_name($stmt, ":contrasena", $contrasena);
    oci_execute($stmt);

    // Verificar si se encontró un usuario
    if ($row = oci_fetch_assoc($stmt)) {
        $_SESSION["usuario"] = $row["nombre_usuario"]; // Almacenar el nombre de usuario en la sesión
        header("Location: index.php"); // Redirigir al usuario a la página de inicio después del inicio de sesión
        exit();
    } else {
        $mensaje_error = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
    }

    // Cerrar la conexión a la base de datos
    oci_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
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
                        <h3 class="text-center">pichi</h3>
                    </div>
                    <div class="card-body ">
                        <?php if (isset($mensaje_error)) : ?>
                            <p><?php echo $mensaje_error; ?></p>
                        <?php endif; ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-3 mt-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-dark"> sesión</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <a href="register.php">¿No tienes una cuenta? Regístrate</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


