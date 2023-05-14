<?php

session_start();

// Bejelentkező oldal

//ha be van jeletkezve, átirányít a home-ba
if (isset($_SESSION['user'])) {
    header('location:home.php');
}
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
                        <h3 class="header-title">Bejelentkezés</h3>
                        <form class="login-form" method="POST" action="login.php">
                            <div class="form-group">
                                <input class="form-control" placeholder="Becenév" type="text" name="username" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Jelszó" type="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login" class="btn btn-lg btn-primary btn-block">Bejelentkezés</button>
                            </div>
                            <div class="form-group">
                                <div class="text-center">Jelentkeznél közénk? <a href="registration.php">Regisztrálj!</a></div>
                            </div>
                        </form>
                        <!-- hibaüzenet -->
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