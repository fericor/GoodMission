<?php
    include '../../control/db.php';
    include '../../control/csrf.php';

    noLogin();

    $id_usuario = $_SESSION['user_id'] ?? 0;
    $id_reto    = intval($_POST['id_reto'] ?? 0);
    $valor      = intval($_POST['valor'] ?? 0);

    if ($id_usuario && $id_reto && $valor >= 1 && $valor <= 5) {
        // Insertar o actualizar valoración
        $stmt = $conn->prepare("INSERT INTO valoraciones (id_reto, id_usuario, puntuacion) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE puntuacion = VALUES(puntuacion)");
        $stmt->bind_param("iii", $id_reto, $id_usuario, $valor);
        $stmt->execute();

        // Recalcular promedio
        $media = $conn->query("SELECT AVG(puntuacion) as promedio, COUNT(*) as cantidad FROM valoraciones WHERE id_reto = $id_reto")->fetch_assoc();
        $promedio = round($media['promedio'], 2);
        $cantidad = $media['cantidad'];

        // Actualizar en tabla retos
        $conn->query("UPDATE retos SET valoracion_total = $promedio * $cantidad, valoracion_cantidad = $cantidad WHERE id = $id_reto");

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'OK',
            'message' => 'Valoración recibida correctamente'
            // Puedes añadir más datos aquí si necesitas
        ]);

        exit();

    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'KO',
            'message' => 'Valoración recibida correctamente'
            // Puedes añadir más datos aquí si necesitas
        ]);

        exit();

    }