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
$sql = "SELECT * FROM tag WHERE tid = '" . $_SESSION['user'] . "'";
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
$kiir->setTura();

$feedback = new Visszajelzo();
$feedback->setJelentkezes();
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

    <div class="roww">
        <div class="leftcolumn">
            <div class="card">
                <button class="tablink" onclick="openPage('Home', this, '#132614')">Főoldal</button>
                <button class="tablink" onclick="openPage('News', this, '#26381B')" id="defaultOpen">Túrák</button>
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

                        <script>
                            // Set the date we're counting down to
                            var countDownDate = new Date("<?php echo $tura['esemeny_datuma']; ?>").getTime();
                            //alert(countDownDate);
                            // Update the count down every 1 second
                            var x = setInterval(function() {

                                // Get today's date and time
                                var now = new Date().getTime();

                                // Find the distance between now and the count down date
                                var distance = now - countDownDate;

                                // Time calculations for days, hours, minutes and seconds
                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                // Display the result in the element with id="demo"
                                document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
                                    minutes + "m " + seconds + "s ";

                                // If the count down is finished, write some text
                                if (distance < 0) {
                                    clearInterval(x);
                                    document.getElementById("demo").innerHTML = "EXPIRED";
                                }
                            }, 1000);
                        </script>
                        <table>
                            <tr>
                                <th>Esemény neve:</th>
                                <th>
                                    <div><?php echo $tura['esemenynev']; ?></div>
                                    <div><span id="demo"></span>
                                    </div>
                                </th>

                            </tr>
                            <tr>
                                <th>Dátum:</th>
                                <th><?php echo $tura['esemeny_datuma']; ?>
                                </th>
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

                        <h5>Eddigi visszajelzések:</h5>
                        <?php
                        $jelentkezesek_tura_szerint = array_filter($jelentkezesek, function ($jelentkezes) use ($tura) {
                            return $jelentkezes['esemenynev'] == $tura['esemenynev'];
                        });
                        ?>
                        <?php if (!empty($jelentkezesek_tura_szerint)) : ?>
                            <!-- <h3>esemény: <?php echo $tura['esemenynev']; ?></h3>-->
                            <?php foreach ($jelentkezesek_tura_szerint as $jelentkezes) : ?>
                                <!--<h3>név</h3>-->
                                <p><?php echo $jelentkezes['becenev'] . ": " . $jelentkezes['valasz'] . "   ( " . $jelentkezes['tag_megjegyzes'] . " )"; ?></p>
                                <!--<h3>válasz</h3>
                                <p><?php echo $jelentkezes['valasz']; ?>/</p>
                                <h3>megjegyzés</h3>
                                <p><?php echo $jelentkezes['tag_megjegyzes']; ?>/</p>-->
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>Nincs jelentkezés</p>
                        <?php endif; ?>
                        <form action="home.php" method="POST">
                            <?php echo '<pre>';
                            print_r($jelentkezesek);      ?>

                            <div><!--id="rejt"-->
                                <div><input type="text" name="esemeny_id" required value="<?php echo $tura['id']; ?>"></div>
                                <input type="text" name="jelentkezes_id" required value="<?php echo $jelentkezesek['id'] ?>">
                                <input type="radio" id="igen" name="answer" value="igen">
                                <label for="igen">Igen</label><br>
                                <input type="radio" id="talan" name="answer" value="talan">
                                <label for="talan">Talán</label><br>
                                <input type="radio" id="nem" name="answer" value="nem">
                                <label for="nem">Nem</label>
                            </div>
                            <div>
                                <textarea placeholder="Megjegyzés:" name="note" cols="20" rows="5" "></textarea>
                            </div>
                            <!--<div class=" form-group">
                            <input class="form-control" placeholder="Szervező:" type="text" name="szervezo">
                        </div>-->
                            <div>
                                <button type="submit" onclick="formReset()" name="feedback">Elküld</button>
                                <button type="submit" onclick="formReset()" name="update">Módosít</button>

                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
                <div id="Contact" class="tabcontent">
                    <h3>Szervező</h3>
                    <form action="home.php" method="POST" target="_blank">
                        <div>
                            <input placeholder="Esemény neve:" type="text" name="esemeny" required>
                        </div>
                        <div>
                            <input placeholder="Esemény dátuma:" type="datetime-local" name="datum" required>
                        </div>
                        <div>
                            <textarea placeholder="Esemény leírása:" name="leir" cols="30" rows="10" required></textarea>
                            </div>
                            <div>
                                <button type="submit" onclick="formReset()" name="send">Elküld</button>
                            </div>
                        </form>
                </div>

                <div id="About" class="tabcontent">
                    <h3>Tagok</h3>


                    <div>
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
                </div>

                <div id="POI" class="tabcontent">
                    <h3>POI</h3>
                    <p>Mi, hol, merre.</p>
                    <div>
                        <p>lorem100

                        </p>
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
<!--"<?php echo $jelentkezes['esemeny_id']; ?>"-->