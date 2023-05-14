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
            return $row['tid'];
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
class Jelszo
{
    private $password;
    private $errors = array();

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function validate()
    {
        if (strlen($this->password) < 8) {
            $this->errors[] = "A jelszó legalább 8 karakter hosszúnak legyen!";
        }
        if (!preg_match("#[0-9]+#", $this->password)) {
            $this->errors[] = "A jelszó tartalmazzon legalább egy számot!";
        }
        if (!preg_match("#[a-zA-Z]+#", $this->password)) {
            $this->errors[] = "A jelszó tartalmazzon legalább egy betűt.";
        }
        if (!preg_match("#[A-Z]+#", $this->password)) {
            $this->errors[] = "A jelszó tartalmazzon legalább egy nagybetűt.";
        }
        if (!preg_match("#[a-z]+#", $this->password)) {
            $this->errors[] = "A jelszó tartalmazzon legalább egy kisbetűt.";
        }
        if (count($this->errors) > 0) {
            return false;
        }
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
