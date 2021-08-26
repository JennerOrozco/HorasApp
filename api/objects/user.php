<?php
include_once '../config/common.php';
class User
{
    // database connection and table name
    private $conn;
    private $table_name = "users";
    private Common $common;

    // object properties
    public $id;
    public $firstName;
    public $lastName;
    public $company;
    public $email;
    public $user;
    public $password;


    public function __construct($db)
    {
        $this->conn = $db;
        $this->common = new Common();
    }

    function create()
    {
        $insertParams = "firstName,lastName,company,user,email,password";

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        $query = $this->common->createInsertQuery($this->table_name, $insertParams);

        $stmt = $this->conn->prepare($query);

        $this->common->sanitize($this, $insertParams);

        $this->common->bindParameter($stmt, $this, $insertParams);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // check if given email exist in the database
    function emailExists()
    {

        $insertParams = "email";

        $query = $this->common->createSelectQuery("id,firstName,lastName,password", $this->table_name, "email=:email", "1");

        $stmt = $this->conn->prepare($query);

        $this->common->sanitize($this, $insertParams);

        $this->common->bindParameter($stmt, $this, $insertParams);

        $stmt->execute();

        $result = $this->common->mappingObj($stmt, $this);

        return $result;
    }
}
