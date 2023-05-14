<!--kísérletezgetés, nincs használva -->

<?php


require_once('DbConnection.php');
class Szervezo extends DbConnection
{
    public function checkTura($esemeny, $datum, $leir, $szervezo)
    {
        $sql3 = "SELECT COUNT(* FROM esemeny WHERE esemenynev = '$esemeny' AND 
                                                    esemeny_datuma = '$datum' AND
                                                    esemeny_leiras = '$leir' AND
                                                    tag_id = '$szervezo'";
              echo '<pre>';
              print_r($sql3);                                     
        $result3 = $this->connection->query($sql3);
        echo '<pre>';
        print_r($result3);                                     


        if ($result3->num_rows() > 0) {
            return true; // van már ilyen sor az adatbázisban
        } else {
            return false; // nincs még ilyen sor az adatbázisban
        }
    }
    public function setTura()
    {
        if (isset($_POST['send'])) {
            $esemeny = 'egy';
            $datum = 'kettő';
            $leir = 'három'
            $szervezo = 'négy';}
        }
    }


/*
            if (!$this->checkTura($esemeny, $datum, $szervezo, $leir)) {
                $esemeny = $this->connection->real_escape_string($esemeny);
                $datum = $this->connection->real_escape_string($datum);
                $leir = $this->connection->real_escape_string($leir);
                $szervezo = $this->connection->real_escape_string($szervezo);

                $sql2 = "INSERT INTO esemeny (id,
                                            esemenynev,
                                            esemeny_datuma,
                                            esemeny_leiras,
                                            tag_id) 
                                VALUES ('',
                                        '$esemeny',
                                        '$datum',
                                        '$leir',                                   
                                        '$szervezo')";
                $result2 = $this->connection->query($sql2);

                if ($result2) {
                    echo "Az esemény sikeresen feltöltve!";
                } else {
                    echo "Adatfeltöltési hiba " . $this->connection->error;
                }
            } else {
                echo "Az esemény már létezik az adatbázisban";
            }
        }
    }
}
*/
<?php foreach ($turak as $tura) : ?>
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
        <?php foreach ($jelentkezesek_tura_szerint as $jelentkezes) : ?>
            <p><?php echo $jelentkezes['becenev'] . ": " . $jelentkezes['valasz'] . "   ( " . $jelentkezes['tag_megjegyzes'] . " )"; ?></p>
        <?php endforeach; ?>
    <?php else : ?>
        <p>Nincs jelentkezés</p>
    <?php endif; ?>
    <form action="home.php" method="POST">
        <div><!--id="rejt"-->
            <div><input type="text" name="esemeny_id" required value="<?php echo $tura['id']; ?>"></div>
            <input type="text" name="jelentkezes_id" required value="<?php echo $jelentkezesek[0]['jid']; ?>">
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
        <div>
            <button type="submit" onclick="formReset()" name="feedback">Elküld</button>
            <button type="submit" onclick="formReset()" name="update">Módosít</button>

        </div>
    </form>
<?php endforeach; ?>
</div>
