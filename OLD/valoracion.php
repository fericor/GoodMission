<?php
session_start();
include 'includes/db.php';

$id_usuario = $_SESSION['user_id'] ?? null;
$id_reto = $_POST['id_reto'] ?? null;
$valor = $_POST['valor'] ?? null;

if ($id_usuario && $id_reto && $valor >= 1 && $valor <= 5) {
    mysqli_query($conn, "UPDATE inscripciones SET valoracion = $valor WHERE id_reto = $id_reto AND id_usuario = $id_usuario");

    mysqli_query($conn, "
        UPDATE retos 
        SET valoracion_total = valoracion_total + $valor, 
            valoracion_cantidad = valoracion_cantidad + 1 
        WHERE id = $id_reto
    ");
}

header("Location: retos.php");
?>
