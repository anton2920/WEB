<?php

/*echo '<pre>' . print_r($_POST, 1) . "</pre>";
echo '<pre>' . print_r($_FILES, 1) . "</pre>";*/

// ---- includes ----
require_once 'includes/connectDB.php';
require_once 'includes/functions.php';
// ------------------

if(isset($_SESSION['user']) || empty($_POST['username'])  || empty($_POST['password'])){
    header("Location: /");
    exit();
}



$sql   = 'SELECT * FROM user WHERE username = ? ';
$query = $pdo->prepare($sql);
$query->execute([$_POST['username']]);

$data = $query->fetch(PDO::FETCH_ASSOC);

if(password_verify($_POST['password'], $data['password'])){
    session_start();
    $_SESSION['user']        = $data['username'];
    $_SESSION['accessToken'] = $data['accessToken'];
    $_SESSION['email']       = $data['email'];
    $_SESSION['avatar']      = $data['avatar'];
    $_SESSION['id']          = $data['id'];

}

header("Location: /");
exit();
?>