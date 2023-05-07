<?php
require_once('DbConnection.php');

class Adatle extends DbConnection
{


    public function __construct()
    {
        parent::__construct();
    }
}

class Adatfel extends DbConnection
{
    public function __construct()
    {
        parent::__construct();
    }
    function turaFel($name, $nickname, $phone, $email, $intro, $psw)
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
