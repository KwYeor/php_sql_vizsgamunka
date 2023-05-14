<?php

//a regisztráció kódsorai

session_start();
require_once('user.php');
// a form nem enged kitöltetlen mezőt, így elegendő ellenőrizni, hogy van e POST
if (isset($_POST['send'])) {

    //veszélyes karakterek szűrése

    $fullname = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $intro = filter_var($_POST['intro'], FILTER_SANITIZE_SPECIAL_CHARS);
    $psw = $_POST['psw'];
    $repsw = $_POST['repsw'];

    // jelszóvalidáció
    if (strlen($psw) < 8 || (!preg_match("#[0-9]+#", $psw)) || (!preg_match("#[a-zA-Z]+#", $psw)) || (!preg_match("#[A-Z]+#", $psw))) {
        $_SESSION['message'] = "A jelszó legalább 8 karakter hosszú legyen, kis és nagybetűt és egy számot is tartalmazzon!";
    } else {
        if ($psw == $repsw) {
            $reg = new Reg();
            if ($reg->regUser($fullname, $username, $phone, $email, $intro, $psw)) {
                $_SESSION['message'] = "Sikeres regisztráció!";
            } else {
                $_SESSION['message'] = "Sikertelen regisztráció!";
            }
        } else {
            $_SESSION['message'] = "A megadott jelszavak nem egyeznek!";
        }
        header('Location: registration.php');
        exit;
    }
}

?>

<!--regisztrációs oldal -->

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <section class="body">
        <div class="container">
            <h1 class="page-header text-center">Túraszervező</h1>
            <div class="login-box">
                <div class="row">
                    <div class="col-12">
                        <div class="logo">
                            Motoros túrák
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <br>
                        <h3 class="header-title">Regisztráció</h3>
                        <form class="login-form" method="POST" action="registration.php">
                            <div class="form-group">
                                <input class="form-control" placeholder="Becenév" type="text" name="username" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Teljes név" type="text" name="name" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Telefon" type="text" name="phone" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Email" type="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Pár szó magadról és a motorodról:" name="intro" cols="30" rows="10" required></textarea>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Jelszó" type="password" name="psw" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Jelszó újra" type="password" name="repsw" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" onclick="" name="send" class="btn btn-lg btn-primary btn-block">Elküld</button>
                            </div>
                            <div class="form-group">
                                <div class="text-center">Már regisztráltál? <a href="index.php">Jelentkezz be!</a></div>
                            </div>
                        </form>
                        <?php
                        if (isset($_SESSION['message'])) {
                        ?>
                            <div class="alert alert-info text-center">
                                <?php echo $_SESSION['message']; ?>
                            </div>
                        <?php

                            unset($_SESSION['message']);
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </section>

</body>

</html>