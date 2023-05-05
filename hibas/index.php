<?php
//start session
session_start();

//redirect if logged in
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
            <h1 class="page-header text-center">PHP Mysqli Login with OOP (Object-Oriented Programming)</h1>
            <div class="login-box">
                <div class="row">
                    <div class="col-12">
                        <div class="logo">
                            Cairocoders
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <br>
                        <h3 class="header-title">Login</h3>
                        <form class="login-form" method="POST" action="login.php">
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" type="text" name="username" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" type="password" name="password" required>
                                <a href="#!" class="forgot-password">Forgot Password?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login" class="btn btn-lg btn-primary btn-block">Login</button>
                            </div>
                            <div class="form-group">
                                <div class="text-center">New Member? <a href="#!">Sign up Now</a></div>
                            </div>
                        </form>
                        <?php //$password = "123456";
                        //echo password_hash($password, PASSWORD_DEFAULT);
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