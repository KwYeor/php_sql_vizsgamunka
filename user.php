<?php
include_once('dbconn.php');
class User extends Dbconn
{
    public function __construct()
    {
        parent::__construct();
    }

    public function check_login($nickname, $password)
    {
        $sql = "SELECT * FROM tag WHERE becenev = '$nickname'";
        $query = $this->connection->query($sql);
        if ($query->num_rows > 0) {
            $row = $query->fetch_array();
            if (password_verify($password, $row['password'])) {
                return $row['id'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function details($sql)
    {

        $query = $this->connection->query($sql);

        $row = $query->fetch_array();

        return $row;
    }
    public function escape_string($value)
    {
        return $this->connection->real_escape_string($value);
    }
}
