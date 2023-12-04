<?php
session_start();

require_once 'conexion.php';

if (isset($_SESSION["usuario"])) {
    $usuario = $_SESSION["usuario"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cerrar_sesion"])) {
    session_destroy();
    header("Location: index.php"); // Redirigir al inicio de sesión después de cerrar la sesión
    exit();
}

// Procesar el formulario de agregar documento
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["titulo"], $_POST["autor"], $_POST["edicion"], $_POST["editorial"], $_POST["anio"], $_POST["tipo"], $_POST["categoria"], $_POST["cantidad"])) {

    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $edicion = $_POST["edicion"];
    $editorial = $_POST["editorial"];
    $anio = $_POST["anio"];
    $tipo = $_POST["tipo"];
    $categoria = $_POST["categoria"];
    $cantidad = $_POST["cantidad"];

    $sql = "INSERT INTO Documento (Tipo, Titulo, Autor, Editorial, Anio, Edicion, Categoria, Cantidad) 
            VALUES (:tipo, :titulo, :autor, :editorial, :anio, :edicion, :categoria, :cantidad)";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ":tipo", $tipo);
    oci_bind_by_name($stmt, ":titulo", $titulo);
    oci_bind_by_name($stmt, ":autor", $autor);
    oci_bind_by_name($stmt, ":editorial", $editorial);
    oci_bind_by_name($stmt, ":anio", $anio);
    oci_bind_by_name($stmt, ":edicion", $edicion);
    oci_bind_by_name($stmt, ":categoria", $categoria);
    oci_bind_by_name($stmt, ":cantidad", $cantidad);

    $result = oci_execute($stmt);

    if ($result) {
        header("Location: indexbiblio.php?documento_creado=true");
        exit();
    } else {
        
        $error = oci_error($stmt);
        echo "Error al agregar el documento: " . $error["message"];
    }

    oci_free_statement($stmt);
    oci_close($conn);
}
?>

