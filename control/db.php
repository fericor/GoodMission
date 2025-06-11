<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    echo "Conectando a la base de datos...<br>";
    // Configuración de la conexión a la base de datos
    $host     = '127.0.0.1';
    $username = 'adminphp';
    $password = 'Swv11w9x**';
    $database = 'good_mission';

    $conn = new mysqli($host, $username, $password, $database);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }