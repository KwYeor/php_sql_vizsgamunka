<?php
require_once('user.php');

$regUser = new Reg();

?>
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
                                <input class="form-control" placeholder="Becenév" type="text" name="username" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Teljes név" type="text" name="fullname" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Telefon" type="text" name="phone" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Email" type="text" name="email" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" placeholder="Pár szó magadról és a motorodról:" name="intro" cols="30" rows="10" required></textarea>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Jelszó" type="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Jelszó újra" type="password" name="repassword" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="send" class="btn btn-lg btn-primary btn-block">Elküld</button>
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