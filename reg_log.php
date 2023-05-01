<?php

session_start();
class Db
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "tura";

    protected $connection;

    public function __construct()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Kapcsolódási hiba: " . $this->connection->connect_error);
        }
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}

class Reg extends Db
{
    function regUser($name, $nickname, $phone, $email, $intro, $psw)
    {
        $hashedPassword = password_hash($psw, PASSWORD_DEFAULT);
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

class Log extends Db
{
    function logUser($nickname, $psw)
    {
        $stmt = $this->connection->prepare("SELECT jelszo FROM tag WHERE becenev = ?");
        $stmt->bind_param("s", $nickname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($psw, $row['jelszo'])) {
                return true;
            }
        }

        return false;
    }
}

$registration = new Reg();
$registration->regUser("peldanev", "peldabecenev", "peldatelefon", "pelda@example.com", "peldaintro", "jelszo123");

$login = new Log();
$loggedIn = $login->logUser("peldabecenev", "jelszo123");
if ($loggedIn) {
    echo "Sikeres bejelentkezés";
} else {
    echo "Hibás felhasználónév vagy jelszó";
}
