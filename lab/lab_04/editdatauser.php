<?php

// Connect to Database
require_once 'includes/connectDB.php';


if(empty($_SESSION['user']) && $_POST['token'] != $_SESSION['accessToken']){
    header('Location: /');
    exit();
}


$sql = "UPDATE user SET email=? WHERE accessToken=?";
$query = $pdo->prepare($sql);
$query->execute([
    $_POST['email'],
    $_SESSION['accessToken']
]);

header("Location: /profile.php");