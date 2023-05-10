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
    function setTura($szervezo, $esemeny, $datum, $leir)
    {
        $stmt = $this->connection->prepare("INSERT INTO esemeny (esemenynev,
                                                                esemeny_datuma,
                                                                esemeny_leiras,
                                                                tag_id )
                                            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssss", $szervezo, $esemeny, $datum, $leir);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
