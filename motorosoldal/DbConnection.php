
<?php

// adatbázis kapcsolat felépítése
//---------------------------------------------------------------
class DbConnection
{

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'tura';

    public $connection;

    public function __construct()
    {

        if (!isset($this->connection)) {

            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

            if (!$this->connection) {
                echo 'Cannot connect to database server';
                exit;
            }
        }

        return $this->connection;
    }
    //  adatbázis logolás
    //------------------------------------------------------------------
    public function loging($txt)
    {
        $sql = "INSERT INTO `log` (`log`) VALUES ( \"$txt\" );";
        if ($this->connection->query($sql) !== true) die($this->connection->error);
    }
}
?>