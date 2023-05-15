<?php

// inaktív fájl
//--------------------------------------------------------


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
                <button class="tablink" onclick="openPage('Home', this, '#132614')" id="defaultOpen">Főoldal</button>
                <button class="tablink" onclick="openPage('News', this, '#26381B')">Túrák</button>
                <button class="tablink" onclick="openPage('Contact', this, '#2F440D')">Szervező</button>
                <button class="tablink" onclick="openPage('About', this, '#344D2D')">Tagok</button>
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
                                <td><?php echo $tura['esemenynev']; ?></td>
                            </tr>
                            <tr>
                                <th>Dátum:</th>
                                <td><?php echo $tura['esemeny_datuma']; ?></td>
                            </tr>
                            <tr>
                                <th>Szervező:</th>
                                <td><?php echo $tura['becenev']; ?></td>
                            </tr>
                            <tr>
                                <th>Leírás:</th>
                                <td><?php echo $tura['esemeny_leiras']; ?></td>
                            </tr>
                            <tr>
                                <th>
                                    <form action="user.php" method="POST">Jelentkezés</form>
                                    <input type="radio" id="igen" name="jelentkezes" value="igen">
                                    <label for="igen">Ott leszek!</label><br>
                                    <input type="radio" id="talan" name="jelentkezes" value="talan">
                                    <label for="talan">Talán</label><br>
                                    <input type="radio" id="nem" name="jelentkezes" value="nem">
                                    <label for="nem">Sajnos kihagyom</label>
                                </th>
                                <td>
                                    <textarea name="komment" id="komment" cols="25" rows="4" placeholder="megjegyzés:"></textarea>
                                    <input type="submit" value="küldés">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </table>
                        <div>
                            <h5>Eddigi jelentkezések:</h5>
                            <?php foreach ($jelentkezesek as $jelentkezes) : ?>
                                <h3>esemény: <?php echo $jelentkezes['esemenynev']; ?></h3>

                                <h3>név</h3>
                                <p><?php echo $jelentkezes['becenev']; ?></p>

                                <h3>válasz</h3>
                                <p><?php echo $jelentkezes['valasz']; ?></p>

                                <h3>megjegyzés</h3>
                                <p><?php echo $jelentkezes['tag_megjegyzes']; ?></p>


                            <?php endforeach; ?>
                        </div>
                </div>
            </div>

            <div id="Contact" class="tabcontent">
                <h3>Szervező</h3>
                <form class="login-form" action="adatkezelo.php" method="POST"></form>
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

            </div>

            <div id="About" class="tabcontent">
                <h3>Tagok</h3>
                <?php foreach ($tagok as $tag) : ?>

                    <div style="overflow-x:auto;">
                        <table>
                            <tr>
                                <th>Név</th>
                                <th></th>
                                <th>Telefon</th>
                                <th>Email</th>
                                <th>Bemutatkozás</th>
                            </tr>
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

    <div class="footer">
        <h2>Footer</h2>
    </div>
    <script src="./home.js"></script>
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

<!--if ($result1 = $this->connection->query("SELECT * FROM esemeny AS e
LEFT JOIN tag AS t ON(e.tag_id = t.id)
ORDER BY esemeny_datuma DESC")) {
    if ($result1->num_rows) {
        $row1 = $result1->fetch_assoc();
        foreach ($row1 as $key => $record) {
        }
    }
}
$tura->getTura();
-->