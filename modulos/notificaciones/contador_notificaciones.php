<?php
session_start();
$id_usuario = $_SESSION['id_usuario'] ?? 0;
$conn = new mysqli('localhost', 'usuario', 'password', 'basedatos');
$count = 0;

if ($id_usuario > 0) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM notificaciones WHERE id_usuario = ? AND leida = 0");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
}
echo $count;
