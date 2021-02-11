<?php

// ---- includes ----
require_once 'includes/connectDB.php';
require_once 'includes/functions.php';
// ------------------

if(isset($_SESSION['user']) || empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_FILES)){
        header("Location: /");
        exit();
    }

    $sql   = 'SELECT * FROM user WHERE username = ? ';
    $query = $pdo->prepare($sql);
    $query->execute([$_POST['username']]);

    $data = $query->fetch(PDO::FETCH_ASSOC);

    if(!empty($data)){
        $_SESSION['singup'] = 'Аккаунт с указанным именем пользователя уже существует.';
        header("Location: /");
        exit();
    }

    $datatype = explode('/', $_FILES['avatar']['type']);
    if($datatype[0] != "image"){
        header("Location: /");
        exit();
    }

    $uploaddir  = dirname(__DIR__) . '/' . $_SERVER['SERVER_NAME'] . '/avatars/';
    $filename   = date('ymdhms') . '.' .$datatype[1];
    $uploadfile = $uploaddir . $filename;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile)) {
        $sql = 'INSERT INTO user(username, password, email, avatar, accessToken) 
                VALUES(:username, :password, :email, :avatar, :accessToken)';

        $query = $pdo->prepare($sql);
        $query->execute([
            'username'      => $_POST['username'],
            'password'      => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'email'         => $_POST['email'],
            'avatar'        => '\avatars\\' . $filename,
            'accessToken'   => password_hash(date('Y-m-d m-s-d'), PASSWORD_DEFAULT)
        ]);

        $_SESSION['singup'] = 'Регистрация успешно завершена.';
    } else {
        $_SESSION['singup'] = 'Не удалось зарегистрировать аккаунт.';
    }

    header("Location: /");
exit();
?>