<?php
if(!empty($_SESSION['user'])){
    header('Location: /');
    exit();
}

setcookie('PHPSESSID', null, -1, '/');
header('Location: /');
exit();