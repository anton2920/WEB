<?php
    // ---- includes ----
    require_once 'functions.php';
    require_once 'config.php';

    // Exception handling: connect to Database
    try {
        $dsn = 'mysql:host=localhost; dbname=lab_04';
        $pdo = new PDO($dsn, 'dmitry', 'Nemezida888!');
    } catch(PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }
?>