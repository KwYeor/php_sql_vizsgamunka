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