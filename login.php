<?php

session_start();
include_once('user.php');
$user = new User();

if (isset($_POST['login'])) {
    $nickname = $user->escape_string($_POST['nickname']);
    $password = $user->escape_string($_POST['password']);
    $auth = $user->check_login($nickname, $password);
    if (!$auth) {
        $_SESSION['message'] = 'Érvénytelen becenév vagy jelszó!';
        header('location:index.php');
    } else {
        $_SESSION['user'] = $auth;
        header('location:home.php');
    }
} else {
    $_SESSION['message'] = 'Jelentkezz be';
    header('location:index.php');
}
