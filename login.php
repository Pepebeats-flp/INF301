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
        <div class="container mt-5 mb-5" style="margin : 0 auto; width: 90%;">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h3 class="text-center">Inicio de sesión</h3>
                        </div>
                        <div class="card-body ">
                            <form action="index.php">
                                <div class="mb-3 mt-3">
                                    <label for="email" class="form-label">Correo electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-dark">Iniciar sesión</button>
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


