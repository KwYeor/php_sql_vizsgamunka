<?php
require_once('DbConnection.php');

// adatbázis lekérdezés tömbbe

class Database extends DbConnection
{

    public function getResultArray($sql)
    {
        if ($this->connection) {
            $result1 = mysqli_query($this->connection, $sql);
            if ($result1) {
                $returnArray = [];
                while ($row1 = mysqli_fetch_assoc($result1)) {
                    $returnArray[] = $row1;
                }
                return $returnArray;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }
}

// események lekérdezése

class Tura
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getTurak(): array
    {
        $sql = "SELECT * FROM esemeny AS e
        LEFT JOIN tag AS t ON(e.tag_id = t.tid)
        ORDER BY esemeny_datuma DESC";
        return $this->database->getResultArray($sql);
    }
}

// Tagok lekérdezése

class Tag
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getTagok(): array
    {
        $sql = "SELECT * FROM tag AS t
                ORDER BY tid ASC";
        return $this->database->getResultArray($sql);
    }
}

// eseményre jelentkezések lekérdezése
class Jelentkezes
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getJelentkezesek(): array
    {
        $sql = "SELECT * FROM jelentkezes AS j
        LEFT JOIN tag AS t ON(j.tag_id = t.tid)
        LEFT JOIN esemeny AS e ON(j.esemeny_id = e.id)
        ORDER BY esemeny_datuma DESC, valasz ASC";
        return $this->database->getResultArray($sql);
    }
}

// események feltöltése

class Szervezo extends DbConnection
{
    public function checkTura($esemeny, $datum, $leir, $szervezo)
    {
        $sql3 = "SELECT id FROM esemeny WHERE esemenynev = '$esemeny' AND 
                                                    esemeny_datuma = '$datum' AND
                                                    esemeny_leiras = '$leir' AND
                                                    tag_id = '$szervezo'";
        echo '<pre>';
        print_r($sql3);

        $result3 = $this->connection->query($sql3);
        echo '<pre>';
        print_r($result3);

        if ($result3->num_rows > 0) {

            return true; // van már ilyen sor az adatbázisban

        } else {
            return false; // nincs még ilyen sor az adatbázisban
        }
    }
    public function setTura()
    {
        if (isset($_POST['send'])) {
            $esemeny = filter_var($_POST['esemeny'], FILTER_SANITIZE_ADD_SLASHES);
            $datum = filter_var($_POST['datum'], FILTER_SANITIZE_ADD_SLASHES);
            $leir = filter_var($_POST['leir'], FILTER_SANITIZE_ADD_SLASHES);
            $szervezo = $_SESSION['user'];

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
                echo '<pre>';
                print_r($sql2);

                $result2 = $this->connection->query($sql2);
                echo '<pre>';
                print_r($result2);


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

// visszajelzések feltöltése

class Visszajelzo extends DbConnection
{
    public function checkJelentkezes($esemenyid, $jelentkezo)
    {
        $sql4 = "SELECT COUNT(*) FROM jelentkezes WHERE esemeny_id = '$esemenyid' AND
                                                        tag_id = '$jelentkezo'";
        $result4 = $this->connection->query($sql4);
        if ($result4->fetch_Column() > 0) {
            return true; // van már ilyen sor az adatbázisban
        } else {
            return false; // nincs még ilyen sor az adatbázisban
        }
    }


    public function setJelentkezes()
    {

        if (isset($_POST['feedback'])) {
            $valasz = filter_var($_POST['answer'], FILTER_SANITIZE_ADD_SLASHES);
            $megjegyzes = filter_var($_POST['note'], FILTER_SANITIZE_ADD_SLASHES);
            $esemenyid = $_POST['esemeny_id'];
            $jelentkezo = $_SESSION['user'];

            if (!$this->checkJelentkezes($esemenyid, $jelentkezo)) {
                $valasz = $this->connection->real_escape_string($valasz);
                $megjegyzes = $this->connection->real_escape_string($megjegyzes);
                $esemenyid = $this->connection->real_escape_string($esemenyid);
                $jelentkezo = $this->connection->real_escape_string($jelentkezo);



                $sql5 =  "INSERT INTO jelentkezes (valasz,
                                                  tag_megjegyzes,
                                                  tag_id,
                                                  esemeny_id) 
                            VALUES ('$valasz',
                                    '$megjegyzes',
                                    '$jelentkezo',
                                    '$esemenyid'
                                     )";

                $result5 = $this->connection->query($sql5);


                if ($result5) {
                    echo "A visszajelzés sikeresen feltöltve!";
                } else {
                    echo "Adatfeltöltési hiba " . $this->connection->error;
                }
            } else {
                echo "A visszajelzés már létezik az adatbázisban";
            }
        }
    }
    public function updateJelentkezes()
    {

        if (isset($_POST['update'])) {
            $valasz = filter_var($_POST['answer'], FILTER_SANITIZE_ADD_SLASHES);
            $megjegyzes = filter_var($_POST['note'], FILTER_SANITIZE_ADD_SLASHES);
            $esemenyid = $_POST['esemeny_id'];
            $jelentkezo = $_SESSION['user'];
            $jelentkezes_id = $_POST['id'];


            $sql6 =  "SELECT * FROM jelentkezes AS j 
            LEFT JOIN tag AS t ON(j.tag_id = t.tid)
            LEFT JOIN esemeny AS e ON(j.esemeny_id = e.id)
            WHERE j.id = '$jelentkezes_id'
            ORDER BY esemeny_datuma DESC, valasz ASC
            UPDATE jelentkezes (valasz,
                                                  tag_megjegyzes)
                            VALUES ('$valasz',
                                    '$megjegyzes')";

            $result6 = $this->connection->query($sql6);


            if ($result6) {
                echo "A módosítás sikeresen feltöltve!";
            } else {
                echo "Adatfeltöltési hiba " . $this->connection->error;
            }
        }
    }
}
