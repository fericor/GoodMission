<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $conn = new mysqli('127.0.0.1', 'phpmyadmin', 'tdvSwv11w9x**', 'good_mission');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
?>
