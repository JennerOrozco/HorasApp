<?php
class Database
{

    // specify your own database credentials
    private $host = "sql530.main-hosting.eu";
    private $db_name = "u474938127_HorasApi";
    private $username = "u474938127_HorasAdmin";
    private $password = "Admin123456789.";
    public $conn;

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
