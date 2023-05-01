<?php
session_start();
// adatbázis kapcsolat létrehozása
class Kapcsolodas
{
    public $host = 'localhost';
    public $user = 'root';
    public $password = '';
    public $db = 'tura';
    public $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->db);
    }
}

//regisztráció adatellenőrzés, adatfeltöltés az adatbázisba
class Regisztralas extends Kapcsolodas
{
    public function regisztralo($name, $nickname, $phone, $email, $psw, $repsw, $intro)
    {
        $dupla = mysqli_query($this->conn, "SELECT * FROM tura.tag WHERE becenev = '$nickname' OR email = '$email' ");
        if (mysqli_num_rows($dupla) > 0) {
            return 10;
        } else {
            if ($psw == $repsw) {
                $sql = "INSERT INTO tura.tag VALUES('','$name', '$nickname', '$phone', '$email', '$psw', '$intro')";
                mysqli_query($this->conn, $sql);
                return 1;
            } else {
                return 100;
            }
        }
    }
}
