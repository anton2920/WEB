<?php
    // ---- includes ----
    require_once 'includes/connectDB.php';
    // ------------------

    $count_pages = DefiningCountPages($pdo);

    // Check № page
    $page = (int)$_GET['page'];
    if(empty($page) || $page >= $count_pages || !is_numeric($page)) {
        $page = 1;
    }

    // Determining question number
    $position = ($page-1)*$ROWS_ON_PAGE;

    // Crearing SQL query for receive data about interviews from $position to $position+10
    $sql = 'SELECT * 
            FROM interviews 
            LIMIT ' . $position . ',' . $ROWS_ON_PAGE ;

    // Main layout
    require_once "includes/headerHTML.php";
?>

<section class="main__board">
    <div class="container-sm">
    <?php if(isset($_SESSION['singup'])):?>
        <div style="width: 100%; padding: 10px; background-color: #33c000; margin-top: 20px; border-radius: 2px; color: white;"> <?= $_SESSION['singup'] ?></div>
    <?php unset($_SESSION['singup']); ?>
    <?php endif;?>
    <?php if(isset($_SESSION['user'])):?>
        <a class="btn btn-dark" role="button" style="width: 20%">Пользователь: <?=$_SESSION['user']?></a>
        <a class="btn btn-primary" href="profile.php" style="width: 10%" role="button">Профиль</a>
    <?php else: ?>
        <button class="btn btn-primary" id="show_singup" role="button">Регистрация</button>
        <button class="btn btn-primary" id="show_singin" role="button">Авторизация</button>
    <?php endif; ?>
        <div class="interview">
            <?php foreach ($pdo->query($sql) as $row):?>
                <div class="item">
                    <a class="interview__item"  <?php if(isset($_SESSION['user'])) {
                        echo 'href="interview.php?id=' . $row['interviewcode'] . '"';
                    } else{
                        echo 'onclick="alert(\'Необходимо авторизоваться\')"';
                    }?>>
                        <? echo $row['title'] ?>
                    </a>
                    <a class="results__btn" href="resultspage.php?id=<? echo $row['interviewcode'] ?>">🏆</a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="pages">
            <?php
                // Create pages on screen
                for($i = 1; $i<$count_pages; $i++) {
                    echo "<a href=\"index.php?page=$i\" class=\"page $i\">$i</a>";
                }
            ?>
        </div>
    </div>
</section>

<!-- Registration pop-up -->
<dialog class="singup">
    <div class="container">
        <div class="register">
            <form class="form_register" method="post" enctype="multipart/form-data" action="/singup.php">
                <h4>Регистрация</h4>
                <br>
                <label for="username">Имя пользователя</label>
                <input type="text" name="username" id="username" required>
                <br>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
                <br>
                <label for="email">Адрес электронной почты</label>
                <input type="email" name="email" id="email" required>
                <br>
                <label for="avatar">Фотография</label>
                <input type="file" name="avatar" id="avatar" required>
                <br><br>

                <input type="submit"  value="Зарегистрироваться">
                <br>

            </form>

            <br><br><br>
            <button id="singup_close">Закрыть</button>
        </div>
    </div>

</dialog>

<script type = text/javascript>
    var dialog_singup = document.querySelector('.singup');
    document.querySelector('#show_singup').onclick = function() {
        dialog_singup.showModal();
    };
    document.querySelector('#singup_close').onclick = function() {
        dialog_singup.close();
    };
</script>


<!-- Log in pop-up -->
<dialog class="singin">
    <div class="container">
        <div class="auth">
            <form class="form_auth" method="post" enctype="multipart/form-data" action="singin.php">
                <h4>Авторизация</h4>
                <br>
                <label for="username">Имя пользователя</label>
                <input type="text" name="username" id="username" required>
                <br>
                <label for="password">Пароль</label>
                <input type="password" name="password" id="password" required>
                <br>
                <input type="submit" value="Войти">
                <br>
                <br>
                <a href="restore.php">Восстановить пароль</a>
            </form>

            <br><br><br>
            <button id="singin_close">Закрыть</button>
        </div>
    </div>
</dialog>

<script type = text/javascript>
    var dialog_singin = document.querySelector('.singin');
    document.querySelector('#show_singin').onclick = function() {
        dialog_singin.showModal();
    }
    document.querySelector('#singin_close').onclick = function() {
        dialog_singin.close();
    };
</script>


<?php
    require_once "includes/endHTML.php";
?>