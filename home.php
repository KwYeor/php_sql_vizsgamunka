<?php
session_start();
if (!isset($_SESSION['user']) || (trim($_SESSION['user']) == '')) {
    header('location:index.php');
}
include_once('user.php');
$user = new User();
$sql = "SELECT * FROM tag WHERE id = '" . $_SESSION['user'] . "'";
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <h1>bejelentkezett oldal</h1>
        <div>
            <h2>üdv itt</h2>
            <h4>felhasználó info:</h4>
            <p>Név: <?php echo $row['nev']; ?></p>
            <p>Becenév: <?php echo $row['becenév']; ?></p>
            <p>Jelszó: <?php echo $row['password']; ?></p>
            <p>Tel: <?php echo $row['telefon']; ?></p>
            <p>email: <?php echo $row['email']; ?></p>
            <p>bemutatkozás: <?php echo $row['bemutatkozas']; ?></p>
            <a href="logout.php">Kijelentkezés</a>
        </div>
    </div>

</body>

</html>