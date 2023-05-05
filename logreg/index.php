<?php
//print_r($_POST);
if (count($_POST) > 0) {
    require_once('user.php');
    $user = new User();
    $errors = $user->signup($_POST);
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
    <form action="other.php" method="POST">
        <h1>Bejelentkezés</h1>
        <div class="container">
            <label for="nickname"><b>Becenév</b></label>
            <input type="text" placeholder="Add meg a beceneved" name="nickname" required>

            <label for="password"><b>Jelszó</b></label>
            <input type="password" placeholder="Add meg a jelszavad" name="password" required>

            <button type="submit" value="login">Bejelentkezés</button>
        </div>

    </form>
    <div class="container">
        <?php if (isset($errors) && is_array($errors) && count($errors) > 0) : ?>
            <div class="error">
                <p>abcdef</p>
                <?php foreach ($errors as $error) : ?>
                    <?= $error ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


        <form action="index.php" method="POST">
            <h1>Regisztráció</h1>

            <label for="name"><b>Név</b></label>
            <input type="text" placeholder="Add meg a neved" name="name" required>

            <label for="nickname"><b>Becenév</b></label>
            <input type="text" placeholder="Add meg a beceneved" name="nickname" required>

            <label for="email"><b>Email</b></label>
            <input id="email" type="email" placeholder="Add meg az email címed" name="email" required><br><br>

            <label for="intro"></label>
            <textarea id="intro" placeholder="Pár szó magadról és a motorodról:" name="intro" rows="30" cols="30" required></textarea><br><br>

            <label for="password"><b>Jelszó</b></label>
            <input type="password" placeholder="Add meg a jelszavad" name="password" required>

            <label for="repassword"><b>Jelszó újra</b></label>
            <input type="password" placeholder="Add meg újra a jelszavad" name="repassword" required>


            <button type="submit" value="signup">Küldés</button>
    </div>

    </form>

</body>

</html>