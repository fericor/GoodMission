<?php
    include '../../control/db.php';
    include '../../control/csrf.php';

    noLogin();
    
    if (!isset($_SESSION['user_id'])) exit;

    $amount = floatval($_POST['amount']);
    $desc   = $_POST['description'];
    $userId = $_SESSION['user_id'];

    $res = $conn->query("SELECT balance FROM users WHERE id = $userId");
    $balance = $res->fetch_assoc()['balance'];

    if ($balance >= $amount) {
        $conn->query("UPDATE users SET balance = balance - $amount WHERE id = $userId");
        $stmt = $conn->prepare("INSERT INTO transactions (user_id, type, amount, description) VALUES (?, 'purchase', ?, ?)");
        $stmt->bind_param("ids", $userId, $amount, $desc);
        $stmt->execute();

        header("Location: ../../wallet.php?msjg=Compra realizada&msj_type=success");
        exit;
        
    } else {
        header("Location: ../../wallet.php?msjg=Saldo insuficiente&msj_type=danger");
        exit;
    }
