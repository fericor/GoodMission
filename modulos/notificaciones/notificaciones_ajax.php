<?php
    include '../../control/db.php';
    include '../../control/csrf.php';

    noLogin();

    $id_usuario = $_SESSION['user_id'] ?? 0;

    $sql = "SELECT id, mensaje, fecha FROM notificaciones WHERE id_usuario = ? ORDER BY fecha DESC LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '<div class="p-3 text-center text-gray-500">Sin notificaciones</div>';
    } else {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="p-3 hover:bg-gray-50 cursor-pointer noti-item" data-id="' . $row['id'] . '">' .
                '<div class="text-sm font-medium text-gray-800">' . htmlspecialchars($row['mensaje']) . '</div>' .
                '<div class="text-xs text-gray-400">' . date('d/m/Y H:i', strtotime($row['fecha'])) . '</div>' .
                '</div>';
        }
    }