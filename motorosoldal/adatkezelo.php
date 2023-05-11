<?php
require_once('DbConnection.php');
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
                LEFT JOIN tag AS t ON(e.tag_id = t.id)
                ORDER BY esemeny_datuma DESC";
        return $this->database->getResultArray($sql);
    }
}

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
                ORDER BY id ASC";
        return $this->database->getResultArray($sql);
    }
}

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
        LEFT JOIN tag AS t ON(j.tag_id = t.id)
        LEFT JOIN esemeny AS e ON(j.esemeny_id = e.id)
        ORDER BY esemeny_datuma DESC, valasz ASC";
        return $this->database->getResultArray($sql);
    }
}
class Szervezo extends DbConnection
{
    public function setTura()
    {
        if (isset($_POST['send'])) {
            $esemeny = filter_var($_POST['esemeny'], FILTER_SANITIZE_ADD_SLASHES);
            $datum = filter_var($_POST['datum'], FILTER_SANITIZE_ADD_SLASHES);
            $leir = filter_var($_POST['leir'], FILTER_SANITIZE_ADD_SLASHES);
            $szervezo = $_SESSION['user'];


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
                echo "A esemény sikeresen feltöltve!";
            } else {
                echo "Adatfeltöltési hiba " . $this->connection->error;
            }
        }
    }
}
