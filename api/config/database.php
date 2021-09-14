<?php
class Database
{

    // specify your own database credentials
    private $host = "";
    private $db_name = "";
    private $username = "";
    private $password = "";
    public $conn;

    public function __construct($host, $name, $user, $pass)
    {
        $this->host = $host;
        $this->db_name = $name;
        $this->username = $user;
        $this->password = $pass;
    }

    // get the database connection
    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
