<?php
class Dbconn
{

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'tura';
    protected $connection;

    public function __construct()
    {
        if (!isset($this->connection)) {
            $this->connection = new Mysqli($this->host, $this->username, $this->password, $this->database);
            if (!$this->connection) {
                echo 'Nincs kapcsolat a szerverrel';
                exit;
            }
        }
        return $this->connection;
    }
}
