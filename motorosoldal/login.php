<?php

// A bejelentkezés kódja

//start session
session_start();

require_once('User.php');

$user = new User();

// Ha történt bejelentkezési kísérlet (a POST ellenőrzés elég, mert a form kitöltése kötelező)
if (isset($_POST['login'])) {
    // veszélyes karakterek szűrése
    $username = $user->escape_string($_POST['username']);
    $password = $user->escape_string($_POST['password']);
    //a név és a jelszó elllenőrzése
    $user->loging("username = " . $username);
    $user->loging("password = " . $password);
    // 
    $cl = $user->check_login($username, $password);
    $clt = $cl ? 'true' : 'false';
    $user->loging("check_login = " . gettype($cl) . " " . $clt);
    // ha a check login változó létrejön, átirányítás a home.php-ra, a eser bekerült a SESSION-be
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
