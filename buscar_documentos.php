<?php
// buscar_documentos.php

// Incluir la conexión a la base de datos
require_once 'conexion.php';

// Obtener los valores del formulario
$documentType = $_POST['document_type'];
$category = $_POST['category'];
$title = $_POST['title'];
$author = $_POST['author'];
$topic = $_POST['topic'];

// Construir la consulta SQL basada en los valores del formulario
$sql = "SELECT * FROM Documento WHERE Tipo = :documentType AND Categoria = :category AND Titulo LIKE :title AND Autor LIKE :author AND Tema LIKE :topic";

// Preparar la consulta
$statement = oci_parse($conn, $sql);

// Vincular los parámetros
oci_bind_by_name($statement, ':documentType', $documentType);
oci_bind_by_name($statement, ':category', $category);
oci_bind_by_name($statement, ':title', '%' . $title . '%');
oci_bind_by_name($statement, ':author', '%' . $author . '%');
oci_bind_by_name($statement, ':topic', '%' . $topic . '%');

// Ejecutar la consulta
oci_execute($statement);

// Obtener los resultados
$resultados = [];
while ($fila = oci_fetch_assoc($statement)) {
    $resultados[] = $fila;
}

// Liberar recursos
oci_free_statement($statement);
oci_close($conn);

// Devolver los resultados en formato JSON
echo json_encode($resultados);
?>
