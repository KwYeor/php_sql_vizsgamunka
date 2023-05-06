<?php
//start session
session_start();

require_once('User.php');

$user = new User();

if (isset($_POST['login'])) {
    $username = $user->escape_string($_POST['username']);
    $password = $user->escape_string($_POST['password']);
    $user->loging("username = " . $username);
    $user->loging("password = " . $password);
    $cl = $user->check_login($username, $password);
    $clt = $cl ? 'true' : 'false';
    $user->loging("check_login = " . gettype($cl) . " " . $clt);

    if ($cl) {
        $auth = $user->user_id($username);
        $_SESSION['message'] .= "Bejelentkeztél!";
        $_SESSION['user'] = $auth;
        header('location:home.php');
    } else {
        $_SESSION['message'] .= 'Hibás felhasználónév vagy jelszó';
        header('location:index.php');
    }
} else {
    $_SESSION['message'] = 'Jelentkezz be!';
    header('location:index.php');
}
