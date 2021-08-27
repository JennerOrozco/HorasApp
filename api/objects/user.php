<?php
include_once '../config/common.php';
class User
{
    // database connection and table name
    public $conn;
    public $table_name = "users";
    public Common $common;

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
        return $this->common->create($insertParams,$this);
    }

    // check if given email exist in the database
    function emailExists()
    {
        $result = $this->common->read("*","email","",$this,"" );
        
        if ($result["success"] == true) {    
            $this->common->inputMappingObj((object) $result["data"][0],$this);            
            return true;
        } else {
            return false;
        }
    }
}
