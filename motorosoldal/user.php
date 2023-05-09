<?php
require_once('DbConnection.php');

class User extends DbConnection
{
    private $salt = 'xXxX';

    public function __construct()
    {
        parent::__construct();
    }

    public function check_login($username, $password)
    {
        $this->loging("cl:" . $username . ":" . $password);
        $sql = "SELECT * FROM tag WHERE becenev = '$username' AND jelszo = '" . md5(md5($password . $this->salt) . $this->salt) . "' ;";
        $this->loging($sql);
        $query = $this->connection->query($sql);
        return ($query->num_rows  > 0);
    }

    public function user_id($username)
    {
        $sql = "SELECT * FROM tag WHERE becenev = '$username' ;";
        $query = $this->connection->query($sql);

        if ($query->num_rows  > 0) {
            $row = $query->fetch_array();
            return $row['id'];
        } else {
            return false;
        }
    }

    public function details($sql)
    {

        $query = $this->connection->query($sql);
        $this->loging("User details:");
        $this->loging($sql);
        $row = $query->fetch_array();

        return $row;
    }

    public function escape_string($value)
    {

        return $this->connection->real_escape_string($value);
    }
}
class Reg extends DbConnection
{
    public $password = "123456";

    private $salt = 'xXxX';
    function regUser($name, $nickname, $phone, $email, $intro, $psw)
    {
        $hashedPassword = md5(md5($psw . $this->salt) . $this->salt);
        $stmt = $this->connection->prepare("INSERT INTO tag 
                                            (nev, becenev, telefon, email, bemutatkozas, jelszo) 
                                            VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $nickname, $phone, $email, $intro, $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
/*
class GetAdat extends DbConnection
{
    public $esemeny;
    public $szervezo;
    public $esemenydatum;
    public $leir;


    public function __construct()
    {
        parent::__construct();
    }
    public function getTura()
    {
        if ($result1 = $this->connection->query("SELECT * FROM esemeny AS e
                                LEFT JOIN tag AS t ON(e.tag_id = t.id)
                                ORDER BY esemeny_datuma DESC")) {
            //echo '<pre>';
            //print_r($result1);
            if ($result1->num_rows) {
                $row1 = $result1->fetch_assoc();
                foreach ($row1 as $key => $record) {
                    echo $key . '=>' . $record . '<br>';
                }

                //echo '<pre>';
                //print_r($result1);
            } else {
                echo 'hiba1';
            }
        } else {
            echo 'hiba2';
        }
    }
}
$tura = new GetAdat();
$tura->getTura();*/
//$esemeny, $szervezo, $esemenydatum, $leir
