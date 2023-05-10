<?php
session_start();
//ha nincs belépve, menjen vissza az indexre
if (!isset($_SESSION['user']) || (trim($_SESSION['user']) == '')) {
    header('location:index.php');
}

require_once('User.php');
require_once('adatkezelo.php');


$user = new User();

//tag adatok bekérése
$sql = "SELECT * FROM tag WHERE id = '" . $_SESSION['user'] . "'";
$row = $user->details($sql);
?>

<?php

require_once 'adatkezelo.php';
$tura = new Tura();
$turak = $tura->getTurak();

$tag = new Tag();
$tagok = $tag->getTagok();

$jelentkezes = new Jelentkezes();
$jelentkezesek = $jelentkezes->getJelentkezesek();

$kiir = new Szervezo();

if (isset($_POST['send'])) {
    $szervezo = $_SESSION['user'];
    $esemeny = filter_var($_POST['esemeny'], FILTER_SANITIZE_ADD_SLASHES);
    $datum = filter_var($_POST['datum'], FILTER_SANITIZE_ADD_SLASHES);
    $leir = filter_var($_POST['leir'], FILTER_SANITIZE_ADD_SLASHES);
} else {
    $_SESSION['message'] .= 'Nem sikerült a feltöltés';
}



?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>motor</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>

    <div class="header">
        <h2>Motoros túrák</h2>
    </div>
    <div class="fejlec">
        <p class="hello">Hello, <?php echo $row['becenev']; ?>!</p><a href="logout.php" class="logout">Kijelentkezés</a>

    </div>

    <div class="row">
        <div class="leftcolumn">
            <div class="card">
                <button class="tablink" onclick="openPage('Home', this, '#132614')">Főoldal</button>
                <button class="tablink" onclick="openPage('News', this, '#26381B')">Túrák</button>
                <button class="tablink" onclick="openPage('Contact', this, '#2F440D')">Szervező</button>
                <button class="tablink" onclick="openPage('About', this, '#344D2D')" id="defaultOpen">Tagok</button>
                <button class="tablink" onclick="openPage('POI', this, '#3B5738')">POI</button>

                <div id="Home" class="tabcontent">
                    <h3>Főoldal</h3>
                    <div class="card">
                        <h2>TITLE HEADING</h2>
                        <h5>Title description, Sep 2, 2017</h5>
                        <div class="fakeimg" style="height:200px;">Image</div>
                        <p>Some text..</p>
                        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
                    </div>

                </div>

                <div id="News" class="tabcontent">
                    <h1>Túrák</h1>
                    <?php foreach ($turak as $tura) : ?>
                        <table>
                            <tr>
                                <th>Esemény neve:</th>
                                <th><?php echo $tura['esemenynev']; ?></th>

                                </th>

                            </tr>
                            <tr>
                                <th>Dátum:</th>
                                <th><?php echo $tura['esemeny_datuma']; ?></th>
                            </tr>
                            <tr>
                                <th>Szervező:</th>
                                <th><?php echo $tura['becenev']; ?></th>
                            </tr>
                            <tr>
                                <th>Leírás:</th>
                                <th><?php echo $tura['esemeny_leiras']; ?></th>
                            </tr>
                        </table>
                        <h5>Eddigi jelentkezések:</h5>
                        <?php
                        $jelentkezesek_tura_szerint = array_filter($jelentkezesek, function ($jelentkezes) use ($tura) {
                            return $jelentkezes['esemenynev'] == $tura['esemenynev'];
                        });
                        ?>
                        <?php if (!empty($jelentkezesek_tura_szerint)) : ?>
                            <h3>esemény: <?php echo $tura['esemenynev']; ?></h3>
                            <?php foreach ($jelentkezesek_tura_szerint as $jelentkezes) : ?>
                                <h3>név</h3>
                                <p><?php echo $jelentkezes['becenev']; ?></p>
                                <h3>válasz</h3>
                                <p><?php echo $jelentkezes['valasz']; ?></p>
                                <h3>megjegyzés</h3>
                                <p><?php echo $jelentkezes['tag_megjegyzes']; ?></p>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>Nincs jelentkezés</p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <div id="Contact" class="tabcontent">
                    <h3>Szervező</h3>
                    <form class="login-form" action="user.php" method="POST"></form>
                    <div class="form-group">
                        <input class="form-control" placeholder="Szervező:" type="text" name="szervezo" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Esemény neve:" type="text" name="esemeny" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Esemény dátuma:" type="date" name="datum" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Esemény leírása:" name="leir" cols="30" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="send" class="btn btn-lg btn-primary btn-block">Elküld</button>
                    </div>
                    <p><?php $_SESSION['message'] ?></p>

                </div>

                <div id="About" class="tabcontent">
                    <h3>Tagok</h3>


                    <div style="overflow-x:auto;">
                        <table>
                            <tr>
                                <th>Név</th>
                                <th></th>
                                <th>Telefon</th>
                                <th>Email</th>
                                <th>Bemutatkozás</th>
                            </tr>
                            <?php foreach ($tagok as $tag) : ?>
                                <tr>
                                    <td><?php echo $tag['becenev']; ?></td>
                                    <td><?php echo $tag['nev']; ?></td>
                                    <td><?php echo $tag['telefon']; ?></td>
                                    <td><?php echo $tag['email']; ?></td>
                                    <td><?php echo $tag['bemutatkozas']; ?></td>
                                </tr>
                            <?php endforeach; ?>

                    </div>

                    <div id="POI" class="tabcontent">
                        <h3>POI</h3>
                        <p>Mi, hol, merre.</p>
                        <div>
                            <iframe src="https://www.google.com/maps/d/embed?mid=1Wn__WAcTFbzjnhwnQ8oyQ9e8x50GPbE&ehbc=2E312F" width="100%" height="480"></iframe>
                        </div>
                    </div>


                </div>
            </div>
            <div class="rightcolumn">
                <div class="card">
                    <h2>Zene:</h2>
                    <div class="fakeimg" style="height:100px;">Image</div>
                    <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
                </div>
                <div class="card">
                    <h3>Hasznos linkek:</h3>
                    <div class="fakeimg">Image</div><br>
                    <div class="fakeimg">Image</div><br>
                    <div class="fakeimg">Image</div>
                </div>
                <div class="card">
                    <h3>Kell ez ide?</h3>
                    <p>Some text..</p>
                </div>
            </div>
        </div>
        <?php require_once('footer.php'); ?>

</body>

</html>

<!-- Write your comments here 
            <div class="col-md-4 col-md-offset-4">
                <h2>Welcome to Homepage </h2>
                <h4>User Info: </h4>
                <p>Name: <?php echo $row['nev']; ?></p>
                <p>Username: <?php echo $row['becenev']; ?></p>
                <p>Password HASH: <?php echo $row['jelszo']; ?></p>
                <p>email: <?php echo $row['email']; ?></p>
                <a href="logout.php" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
            </div>-->

<!--https://www.w3schools.com/howto/howto_css_image_text.asp-->

<!--https://www.w3schools.com/howto/howto_js_filter_lists.asp-->
<!--https://www.w3schools.com/howto/howto_css_responsive_form.asp-->
<!--https://www.w3schools.com/howto/howto_js_countdown.asp-->
<!--https://www.w3schools.com/howto/howto_css_profile_card.asp-->
<!--https://www.w3schools.com/howto/howto_css_social_media_buttons.asp-->
<!--https://www.w3schools.com/howto/howto_js_scroll_to_top.asp-->
<!--https://www.w3schools.com/howto/howto_js_image_grid.asp-->