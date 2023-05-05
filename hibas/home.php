<?php
session_start();
//return to login if not logged in
//print_r ($_SESSION);
if (!isset($_SESSION['user']) || (trim($_SESSION['user']) == '')) {
    header('location:index.php');
}

require_once('User.php');

$user = new User();

//fetch user data
$sql = "SELECT * FROM tag WHERE id = '" . $_SESSION['user'] . "'";
$row = $user->details($sql);

?>
<!DOCTYPE html>
<html>

<head>
    <title>PHP Mysqli OOP Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="page-header text-center">PHP Mysqli OOP Login</h1>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h2>Welcome to Homepage </h2>
                <h4>User Info: </h4>
                <p>Name: <?php echo $row['nev']; ?></p>
                <p>Username: <?php echo $row['becenev']; ?></p>
                <p>Password HASH: <?php echo $row['jelszo']; ?></p>
                <p>email: <?php echo $row['email']; ?></p>
                <a href="logout.php" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
            </div>
        </div>
    </div>
</body>

</html>