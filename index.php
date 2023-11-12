<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de catalogo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="catalogo.css">
    <script src="https://kit.fontawesome.com/a4490af95b.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-light bg-light shadow-sm">
        <div class="container">
            <span style="font-size: 20px;">
                <i class="fa-solid fa-user"></i> Carlos Lagos
            </span>
            <span style="cursor: pointer;font-size: 20px; text-align: right;">
                <a href="carro.php" style="text-decoration: none; color: black;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
            </span>
        </div> 
    </nav>
    <div class="container shadow-sm rounded p-2 mt-2">
        <h2>Búsqueda de documentos:</h2>
        <form class="p-3">
            <div class="form-group row mb-3">
                <label for="document_type" class="col-sm-3 col-form-label">Tipo de documento: </label>
                <div class="col-sm-9">
                    <select id="document_type" class="form-select">
                        <option>Libros Técnicos</option>
                        <option>Libros de arte</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="category" class="col-sm-3 col-form-label">Categoría: </label>
                <div class="col-sm-9">
                    <select id="category" class="form-select">
                        <option>Ingeniería Informatica</option>
                        <option>Ingeniería Comercial</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="title" class="col-sm-3 col-form-label">Titulo: </label>
                <div class="col-sm-9">
                    <input type="text" class="form form-control" id="title" placeholder="Ingresa el titulo...">
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="author" class="col-sm-3 col-form-label">Autor: </label>
                <div class="col-sm-9">
                    <input type="text" class="form form-control" id="author" placeholder="Ingresa el autor...">
                </div>
            </div>
            <div class="form-group row mb-3">
                <label for="topic" class="col-sm-3 col-form-label">Tema: </label>
                <div class="col-sm-9">
                    <input type="text" class="form form-control" id="topic" placeholder="Ingresa el tema...">
                </div>
            </div>
            <div style="text-align: right;">
                <button class="btn btn-outline-dark">Volver</button>
                <button class="btn btn-dark">Aplicar filtro</button>
            </div>
        </form>
    </div>
    <div class="container shadow-sm rounded p-2 mt-2">
        <h2>Documentos encontrados: </h2>
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
                    <tr>
                        <td>Ingeniería de Software</td>
                        <td>El Ingeniero</td>
                        <td>4° Edición</td>
                        <td>2005</td>
                        <td>Libro Técnico</td>
                        <td>Ingeniería Informatica</td>
                        <td>3</td>
                        <td>
                            <input type="checkbox">
                        </td>
                    </tr>
                    <tr>
                        <td>Ingeniería de Software</td>
                        <td>El Ingeniero</td>
                        <td>4° Edición</td>
                        <td>2005</td>
                        <td>Libro Técnico</td>
                        <td>Ingeniería Informatica</td>
                        <td>3</td>
                        <td>
                            <input type="checkbox">
                        </td>
                    </tr>
                    <tr>
                        <td>Ingeniería de Software</td>
                        <td>El Ingeniero</td>
                        <td>4° Edición</td>
                        <td>2005</td>
                        <td>Libro Técnico</td>
                        <td>Ingeniería Informatica</td>
                        <td>3</td>
                        <td>
                            <input type="checkbox">
                        </td>
                    </tr>
                    <tr>
                        <td>Ingeniería de Software</td>
                        <td>El Ingeniero</td>
                        <td>4° Edición</td>
                        <td>2005</td>
                        <td>Libro Técnico</td>
                        <td>Ingeniería Informatica</td>
                        <td>3</td>
                        <td>
                            <input type="checkbox">
                        </td>
                    </tr>
                    <tr>
                        <td>Ingeniería de Software</td>
                        <td>El Ingeniero</td>
                        <td>4° Edición</td>
                        <td>2005</td>
                        <td>Libro Técnico</td>
                        <td>Ingeniería Informatica</td>
                        <td>3</td>
                        <td>
                            <input type="checkbox">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="text-align: right;">
            <button class="btn btn-dark">Agregar a Solicitud</button>
        </div>
    </div>
</body>
</html>