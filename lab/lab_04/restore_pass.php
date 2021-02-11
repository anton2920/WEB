<?php
// ---- includes ----
require_once 'includes/connectDB.php';
// ------------------

$changePass = false;

if(isset($_SESSION['user'])){
    header("Location: /");
    exit();
}

if(!empty($_POST['password']) && !empty($_POST['token'])){

    $sql = "UPDATE user SET password=? WHERE accessToken=?";
    $query = $pdo->prepare($sql);
    $query->execute([
        password_hash($_POST['password'], PASSWORD_DEFAULT),
        $_POST['token']
    ]);
    $changePass = true;
}


require_once "includes/headerHTML.php";
?>
<?php if($changePass):?>
    <div class="container" style="display: flex; justify-content: center; ">
        <div class="restore">
            <br>
            <h4>Пароль успешно изменён</h4>
        </div>
        <a class="btn btn-primary" href="index.php" role="button">Вернуться</a>
    </div>
<?php elseif(!$changePass):?>
    <div class="container" style="display: flex; justify-content: center; ">
        <div class="restore">
            <br><br>
            <form class="form_restore" method="post" enctype="multipart/form-data" action="/restore_pass.php">
                <h4>Введите новый пароль</h4>
                <br>
                <label for="password">Пароль</label>
                <input type="hidden" name="token" value="<?=$_GET['token']?>">
                <input type="password" name="password" id="password" required>
                <input type="submit"  value="Сохранить">
                <br>
            </form>
        </div>
    </div>
<?php endif;?>


<?php
require_once "includes/endHTML.php";
?>