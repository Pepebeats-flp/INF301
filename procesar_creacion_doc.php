<?php
session_start();

// Incluir la conexión a la base de datos (asumiendo que ya tienes esto configurado en 'conexion.php')
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

// Procesar el formulario de agregar documento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["titulo"], $_POST["autor"], $_POST["edicion"], $_POST["editorial"], $_POST["anio"], $_POST["tipo"], $_POST["categoria"], $_POST["cantidad"])) {

    // Obtener los datos del formulario
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $edicion = $_POST["edicion"];
    $editorial = $_POST["editorial"];
    $anio = $_POST["anio"];
    $tipo = $_POST["tipo"];
    $categoria = $_POST["categoria"];
    $cantidad = $_POST["cantidad"];

    // Preparar la consulta SQL con marcadores de posición
    $sql = "INSERT INTO Documento (Tipo, Titulo, Autor, Editorial, Anio, Edicion, Categoria, Cantidad) 
            VALUES (:tipo, :titulo, :autor, :editorial, :anio, :edicion, :categoria, :cantidad)";

    // Preparar la declaración OCI8
    $stmt = oci_parse($conn, $sql);

    // Vincular parámetros
    oci_bind_by_name($stmt, ":tipo", $tipo);
    oci_bind_by_name($stmt, ":titulo", $titulo);
    oci_bind_by_name($stmt, ":autor", $autor);
    oci_bind_by_name($stmt, ":editorial", $editorial);
    oci_bind_by_name($stmt, ":anio", $anio);
    oci_bind_by_name($stmt, ":edicion", $edicion);
    oci_bind_by_name($stmt, ":categoria", $categoria);
    oci_bind_by_name($stmt, ":cantidad", $cantidad);

    // Ejecutar la consulta
    $result = oci_execute($stmt);

    if ($result) {
        header("Location: indexbiblio.php?documento_creado=true");
        exit();
    } else {
        
        $error = oci_error($stmt);
        echo "Error al agregar el documento: " . $error["message"];
    }

    // Liberar recursos
    oci_free_statement($stmt);
    oci_close($conn);
}
?>

