<?php

// Connect to Database
require_once 'includes/connectDB.php';


if(!isset($_SESSION['user'])){
    header('Location: /');
    exit();
}


$sql   = 'SELECT * FROM user WHERE id = ? ';
$query = $pdo->prepare($sql);
$query->execute([$_SESSION['id']]);

$data = $query->fetch(PDO::FETCH_ASSOC);

$_SESSION['user']        = $data['username'];
$_SESSION['accessToken'] = $data['accessToken'];
$_SESSION['email']       = $data['email'];
$_SESSION['avatar']      = $data['avatar'];
$_SESSION['id']          = $data['id'];






$tempToken = password_hash(date("y-m-d-h-m-s"), PASSWORD_DEFAULT);
$_SESSION['token'] = $tempToken;
    // Main layout
    require_once "includes/headerHTML.php";
?>
    <section class="main__board">
        <div class="container-sm">
            <a class="btn btn-primary" href="index.php" role="button">Назад</a>
            <div class="profile">
                <div><img src="<?=$_SESSION['avatar']?>"  style="border-radius: 4px; width: 300px; height: 250px; margin-top: 20px"></div>
                <div class="username"><h4>username: </h4> <?=$_SESSION['user']?></div>
                <div class="email"><h4>email: </h4> <?=$_SESSION['email']?></div>
                <a class="btn btn-primary" style="width: 40%" href="addpage.php" role="button">Добавить новый опрос</a>
                <a class="btn btn-primary" style="width: 40%" href="editprofile.php?token=<?=$tempToken?>" role="button">Изменить данные профиля</a>
                <a class="btn btn-primary" style="width: 40%" href="singout.php" role="button">Выйти из аккаунта</a>
            </div>
        </div>
    </section>
<?php
    require_once "includes/endHTML.php";
?>