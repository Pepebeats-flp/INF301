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

// Procesar el formulario de modificación de documento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    
    // Obtener el ID del formulario
    $id = $_POST["id"];

    // Inicializar variables para campos que pueden no estar presentes en el formulario
    $titulo = null;
    $autor = null;
    $edicion = null;
    $editorial = null;
    $anio = null;
    $tipo = null;
    $categoria = null;
    $cantidad = null;

    // Obtener y asignar valores solo para los campos proporcionados en el formulario
    if (isset($_POST["titulo"])) {
        $titulo = $_POST["titulo"];
    }
    if (isset($_POST["autor"])) {
        $autor = $_POST["autor"];
    }
    if (isset($_POST["edicion"])) {
        $edicion = $_POST["edicion"];
    }
    if (isset($_POST["editorial"])) {
        $editorial = $_POST["editorial"];
    }
    if (isset($_POST["anio"])) {
        $anio = $_POST["anio"];
    }
    if (isset($_POST["tipo"])) {
        $tipo = $_POST["tipo"];
    }
    if (isset($_POST["categoria"])) {
        $categoria = $_POST["categoria"];
    }
    if (isset($_POST["cantidad"])) {
        $cantidad = $_POST["cantidad"];
    }

    // Construir la consulta SQL de actualización
    $sql = "UPDATE Documento SET 
            Tipo = NVL(:tipo, Tipo),
            Titulo = NVL(:titulo, Titulo),
            Autor = NVL(:autor, Autor),
            Editorial = NVL(:editorial, Editorial),
            Anio = NVL(:anio, Anio),
            Edicion = NVL(:edicion, Edicion),
            Categoria = NVL(:categoria, Categoria),
            Cantidad = NVL(:cantidad, Cantidad)
            WHERE Identificador = :id";

    // Preparar la declaración
    $stmt = oci_parse($conn, $sql);

    // Vincular parámetros
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':tipo', $tipo);
    oci_bind_by_name($stmt, ':titulo', $titulo);
    oci_bind_by_name($stmt, ':autor', $autor);
    oci_bind_by_name($stmt, ':editorial', $editorial);
    oci_bind_by_name($stmt, ':anio', $anio);
    oci_bind_by_name($stmt, ':edicion', $edicion);
    oci_bind_by_name($stmt, ':categoria', $categoria);
    oci_bind_by_name($stmt, ':cantidad', $cantidad);

    // Ejecutar la consulta
    if (oci_execute($stmt)) {
        // Éxito al modificar el documento
        echo "Documento modificado con éxito";
        header("Location: indexbiblio.php?modificado=true"); // Puedes redirigir a donde desees después de la modificación
        exit();
    } else {
        // Error al modificar el documento
        echo "Error al modificar el documento: " . oci_error($conn);
    }
}
?>



