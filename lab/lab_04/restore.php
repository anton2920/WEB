<?php
    // ---- includes ----
    require_once 'includes/connectDB.php';
    // ------------------


if(isset($_SESSION['user'])){
   header("Location: /");
   exit();
}


if(!empty($_POST['email'])){
    $sql   = 'SELECT * FROM user WHERE email = ? ';
    $query = $pdo->prepare($sql);
    $query->execute([$_POST['email']]);

    $data  = $query->fetch(PDO::FETCH_ASSOC);

    if(empty($data)){
        header("Location: /");
        exit();
    }

    $tempToken = password_hash(date("y-m-d-h-m-s"), PASSWORD_DEFAULT);
    $sql = "UPDATE user SET accessToken=? WHERE id=" . $data['id'];
    $query = $pdo->prepare($sql);
    $query->execute([$tempToken]);

}

    require_once "includes/headerHTML.php";
?>

<div class="container" style="display: flex; justify-content: center; ">
    <div class="restore">
        <br><br>
        <form class="form_restore" method="post" enctype="multipart/form-data" action="/restore.php">
            <h4>Для восстановления введите адрес электронной почты от вашего аккаунта:</h4>
            <br>
            <label for="email">Адрес электронной почты</label>
            <input type="email" name="email" id="email" required>
            <input type="submit"  value="Восстановить">
            <br>
        </form>
        <?php if(!empty($data)):?>
            <a href="/restore_pass.php?token=<?=$tempToken?>">Сыллка отправленная на электронную почту.</a>
        <?php endif;?>
    </div>
</div>

<?php
    require_once "includes/endHTML.php";
?>