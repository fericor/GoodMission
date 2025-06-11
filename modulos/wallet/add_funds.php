<?php
    include '../../control/db.php';
    include '../../control/csrf.php';

    noLogin();
    
    if (!isset($_SESSION['user_id'])) exit;

    $amount = floatval($_POST['amount']);
    $userId = $_SESSION['user_id'];

    $conn->query("UPDATE users SET balance = balance + $amount WHERE id = $userId");
    $conn->query("INSERT INTO transactions (user_id, type, amount, description) VALUES ($userId, 'add', $amount, 'Recarga')");

    header("Location: ../../wallet.php");
