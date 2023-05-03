<?php
session_start();
if (isset($_['user'])) {
    header('location:home.php');
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <form action="index.php" method="POST">
        <div class="imgcontainer">
            <img src="img_avatar2.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="nickname"><b>Becenév</b></label>
            <input type="text" placeholder="Add meg a beceneved" name="nickname" required>

            <label for="password"><b>Jelszó</b></label>
            <input type="password" placeholder="Add meg a jelszavad" name="password" required>

            <button type="submit" name="login">Bejelentkezés</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button" class="cancelbtn">Cancel</button>
            <span class="psw">Közénk szeretnél tartozni? <a href="#">Regisztrálás</a></span>
        </div>
    </form>
    <?php /*$password = 'tjelszo123';
    echo password_hash($password, PASSWORD_DEFAULT);*/
    if (isset($_SESSION['message'])) { ?>
        <div>
            <p>
                <?php echo $_SESSION['message']; ?>
            </p>
        </div>
    <?php unset($_SESSION['message']);
    } ?>
</body>

</html>