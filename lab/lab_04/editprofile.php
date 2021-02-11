<?php

// Connect to Database
require_once 'includes/connectDB.php';


if(!isset($_SESSION['user'])){
    header('Location: /');
    exit();
}

// Main layout
require_once "includes/headerHTML.php";
?>
    <section class="main__board">
        <div class="container-sm">
            <a class="btn btn-primary" href="index.php" role="button">Назад</a>
            <form class="profile" action="editdatauser.php" method="post">
                <input type="hidden" name="token" value="<?=$_GET['token']?>">
                <h4>email: </h4> <input  style="width: 400px" name="email" value="<?=$_SESSION['email']?>"><br>
                <input type="submit">
            </form>
        </div>
    </section>
<?php
require_once "includes/endHTML.php";
?>
