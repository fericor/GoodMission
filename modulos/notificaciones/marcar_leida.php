<?php
    include '../../control/db.php';
    include '../../control/csrf.php';

    noLogin();

    $id_usuario = $_SESSION['user_id'] ?? 0;
    $id_noti    = intval($_POST['id'] ?? 0);

    if ($id_usuario > 0 && $id_noti > 0) {
        $stmt = $conn->prepare("UPDATE notificaciones SET leida = 1 WHERE id = ? AND id_usuario = ?");
        $stmt->bind_param("ii", $id_noti, $id_usuario);
        $stmt->execute();
        echo "ok";
    } else {
        http_response_code(403);
        echo "error";
    }
