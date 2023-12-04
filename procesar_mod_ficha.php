<?php
require_once 'conexion.php';

// Verificar si se han proporcionado los datos necesarios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"], $_POST["nombres"], $_POST["apellidos"], $_POST["rut"], $_POST["direccion"], $_POST["telefono"])) {

    $id = $_POST["id"];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $rut = $_POST["rut"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];

    $sql = "UPDATE Usuario SET 
                NOMBRES = NVL(:nombres, NOMBRES), 
                APELLIDOS = NVL(:apellidos, APELLIDOS), 
                RUT = NVL(:rut, RUT), 
                DIRECCION = NVL(:direccion, DIRECCION), 
                TELEFONO_ACTIVO = NVL(:telefono, TELEFONO_ACTIVO)
            WHERE IDENTIFICADOR = :id";

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':nombres', $nombres);
    oci_bind_by_name($stmt, ':apellidos', $apellidos);
    oci_bind_by_name($stmt, ':rut', $rut);
    oci_bind_by_name($stmt, ':direccion', $direccion);
    oci_bind_by_name($stmt, ':telefono', $telefono);

    if (oci_execute($stmt)) {
        // Éxito al modificar la ficha de usuario
        echo "Ficha de usuario modificada con éxito";
        header("Location: ficha_individual.php?id=" . $id . "&ficha_modificada=true");

        exit();
    } else {
        // Error al modificar la ficha de usuario
        echo "Error al modificar la ficha de usuario: " . oci_error($conn);
    }
} else {
    header("Location: fichas_usuario.php");
    exit();
}
?>

