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

$admintura = new Szervezo();
$admintura->updateTura();

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
        <img src="./assets/wallpaper-mania.com_High_resolution_wallpaper_background_ID_77700349076.jpg" alt="Fire" style="width:100%;">
        <div class="bottom-left">
            <p class="hello">Hello, <?php echo $row['becenev']; ?>!</p>
        </div>
        <div class="top-left">.</div>
        <div class="top-right">.</div>
        <div class="bottom-right">
            <p><a href="logout.php" class="logout">Kijelentkezés</a></p>
        </div>
        <div class="centered">
            <h2>Motoros túrák</h2>
        </div>
    </div>

    <div class="roww">
        <div class="leftcolumn">
            <div class="card">

                <button class="tablink" onclick="openPage('News', this, '#ff0000d7')" id="defaultOpen">Események</button>
                <button class="tablink" onclick="openPage('Contact', this, '#ff0000d7')">Kiírás</button>
                <button class="tablink" onclick="openPage('About', this, '#ff0000d7')">Tagok</button>
                <button class="tablink" onclick="openPage('Home', this, '#ff0000d7')">Szerkesztő</button>

                <!--<button class="tablink" onclick="openPage('POI', this, '#3B5738')">POI</button>
                ha ezt visszaállítom, akkor a tablinkek szélességét csökkenteni kell 20%-ra!-->

                <div id="Home" class="tabcontent">
                    <h3>Események felülírása</h3>
                    <div class="card">
                        <p>Az esemény kiválasztásához gördítsd le a listát:</p>
                        <form action="home.php" method="POST">
                            <label for="event"></label>
                            <select id="event" name="event">
                                <option value="">Válassz egy eseményt</option>
                                <!-- az események behívása-->
                                <?php foreach ($turak as $tura) : ?>
                                    <option value="<?php echo $tura['id']; ?>"><?php echo $tura['esemenynev']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div>
                                <input placeholder="Esemény dátuma:" type="datetime-local" name="ujdatum" required>
                            </div>
                            <div>
                                <textarea id="leiras" name="atir" cols="30" rows="10" required></textarea>
                            </div>

                            <!-- a visszaszámláló js kódja-->

                            <script>
                                var turak = <?php echo json_encode($turak); ?>;
                                var select = document.getElementById('event');
                                var textarea = document.getElementById('leiras');
                                select.addEventListener('change', function() {
                                    var selected = select.value;
                                    var leiras = turak.find(function(tura) {
                                        return tura.id == selected;
                                    }).esemeny_leiras;
                                    textarea.value = leiras;
                                });
                            </script>

                            <button type="submit" name="admintura">Módosítás</button>
                        </form>
                    </div>
                </div>

                <div id="News" class="tabcontent">
                    <h1>Túrák</h1>

                    <!-- az esemény megjelenítése-->
                    <!-- az esemény táblaadatainak behívása-->

                    <p><a href="home.php" class="logout">Frissítés</a></p>
                    <?php foreach ($turak as $tura) : ?>
                        <script>
                            // Set the date we're counting down to
                            var countDownDate<?php echo $tura['id']; ?> = new Date("<?php echo $tura['esemeny_datuma']; ?>").getTime();
                            //alert(countDownDate);
                            // Update the count down every 1 second
                            var x<?php echo $tura['id']; ?> = setInterval(function() {
                                // Get today's date and time
                                var now = new Date().getTime();
                                // Find the distance between now and the count down date
                                var distance = countDownDate<?php echo $tura['id']; ?> - now;
                                // Time calculations for days, hours, minutes and seconds
                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                // Display the result in the element with id="demo"
                                document.getElementById("demo<?php echo $tura['id']; ?>").innerHTML = "Még " + days + " nap " + hours + " óra " +
                                    minutes + " perc " + seconds + " másodperc ";
                                // If the count down is finished, write some text
                                if (distance < 0) {
                                    clearInterval(x<?php echo $tura['id']; ?>);
                                    document.getElementById("demo<?php echo $tura['id']; ?>").innerHTML = '<p style="color: red;">ELMÚLT ESEMÉNY!</p>';

                                }
                            }, 1000);
                        </script>
                        <table>
                            <tr>
                                <th>Esemény neve:</th>
                                <th>
                                    <div><?php echo $tura['esemenynev']; ?></div>
                                </th>
                            </tr>
                            <tr>
                                <th>Dátum:</th>
                                <div>
                                    <th><?php echo $tura['esemeny_datuma']; ?>
                                </div>
                                <div><span id="demo<?php echo $tura['id']; ?>"></span></div>
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

                        <!-- az eseményekhez tartozó jelentkezések táblaadatainak behívása-->

                        <?php
                        $jelentkezesek_tura_szerint = array_filter($jelentkezesek, function ($jelentkezes) use ($tura) {
                            return $jelentkezes['esemenynev'] == $tura['esemenynev'];
                        });
                        ?>
                        <?php if (!empty($jelentkezesek_tura_szerint)) : ?>

                            <?php foreach ($jelentkezesek_tura_szerint as $jelentkezes) : ?>

                                <p><?php echo $jelentkezes['becenev'] . ": " . $jelentkezes['valasz'] . "   ( " . $jelentkezes['tag_megjegyzes'] . " )"; ?></p>

                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>Nincs még visszajelzés</p>
                        <?php endif; ?>

                        <!-- visszajelzések leadása vagy nódosítása-->

                        <form action="home.php" method="POST">
                            <div><!--id="rejt"-->
                                <div id="rejt"><input type="text" name="esemeny_id" required value="<?php echo $tura['id']; ?>"></div>
                                <input type="radio" id="igen" name="answer" value="igen">
                                <label for="igen">Igen</label><br>
                                <input type="radio" id="talan" name="answer" value="talán">
                                <label for="talan">Talán</label><br>
                                <input type="radio" id="nem" name="answer" value="nem">
                                <label for="nem">Nem</label>
                            </div>
                            <div>
                                <textarea placeholder="Megjegyzés:" name="note" cols="20" rows="5" "></textarea>
                            </div>
                            <div>
                                <button type=" submit" onclick="formReset()" name="feedback">Küldés / Módosítás</button>

                            </div>

                        </form>

                    <?php endforeach; ?>
                </div>

<!-- az eseményszerkesztő-->  

                <div id="Contact" class="tabcontent">
                <div class="forma">    
                <div class="form1">  
                <h3>Események szervezése</h3>
                    <form name="form1" action="home.php" method="POST" >
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
                                <button type="submit" name="send">Elküld</button>
                            </div>
                </div>
            </div>
        </div>

        <!-- a tag táblaadatainak behívása-->

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
        </div>
        <!--a POI fül, jelenleg inaktív-->
        <!--<div id="POI" class="tabcontent">
            <h3>POI</h3>
            <p>Mi, hol, merre.</p>
            <div>
                <p>lorem100

                </p>
                <iframe src="https://www.google.com/maps/d/embed?mid=1Wn__WAcTFbzjnhwnQ8oyQ9e8x50GPbE&ehbc=2E312F" width="100%" height="480"></iframe>
            </div>
        </div>-->
    </div>

    </div>
    <!-- az oldalsáv, jelenleg inaktív-->
    <!--<div class="rightcolumn">
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
    </div>-->

    <!-- az oldalsáv, jelenleg inaktív  -->

    <!--   <div class="footer">
        <h2>Footer</h2>
    </div>-->
    <script src="./home.js"></script>

</body>

</html>