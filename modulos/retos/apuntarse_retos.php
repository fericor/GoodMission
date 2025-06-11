<?php
    include '../../control/db.php';
    include '../../control/csrf.php';

    noLogin();

    $id_usuario = $_SESSION['user_id'] ?? null;
    $id_reto    = $_POST['id_reto'] ?? null;
    $accion     = $_POST['accion'] ?? 'apuntar';

    if ($accion == 'apuntar') {
        $existe = mysqli_query($conn, "SELECT * FROM inscripciones WHERE id_usuario = $id_usuario AND id_reto = $id_reto");
        if (mysqli_num_rows($existe) == 0) {
            $q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM inscripciones WHERE id_reto = $id_reto");
            $inscritos = mysqli_fetch_assoc($q)['total'];

            $q2 = mysqli_query($conn, "SELECT max_participantes FROM retos WHERE id = $id_reto");
            $limite = mysqli_fetch_assoc($q2)['max_participantes'];

            if ($inscritos < $limite) {
                mysqli_query($conn, "INSERT INTO inscripciones (id_reto, id_usuario) VALUES ($id_reto, $id_usuario)");
            }
        }
    } elseif ($accion == 'retirar') {
        mysqli_query($conn, "DELETE FROM inscripciones WHERE id_usuario = $id_usuario AND id_reto = $id_reto");
    }

    header("Location: ../../mis-retos.php");
    exit;