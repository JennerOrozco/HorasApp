<?php
include_once __DIR__ . '/../common/class/crud.php';

class User extends CRUD
{

    public $conn;
    public $table_name = "userweb";

    public $id;
    public $nombres;
    public $correo;
    public $user;
    public $password;


    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getAll()
    {
        return $this->_read("*", "", "", $this, "");
    }

    public function getById()
    {
        return $this->_read("*", "id=", "", $this, "");
    }


    public function createUser()
    {
        $insertParams = "nombres,correo,user,password";

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        return $this->_create($insertParams, $this);
    }

    function updateUser()
    {
        $updateParams = "nombres,correo";

        $whereParams = "id=";

        return $this->_update($updateParams, $whereParams, $this);
    }

    function deteleById()
    {
        $whereParams = "id=";
        return $this->_delete($whereParams, $this);
    }


    function existField($string)
    {
        $result = $this->_read("*", $string, "", $this, "");

        if ($this->validateStatus($result)) {

            $this->inputMappingObj((object) $result["data"][0], $this);

            return true;
        } else {

            return false;
        }
    }

    function loadById()
    {
        $result = $this->_read("*", "id=", "", $this, "");

        if ($this->validateStatus($result)) {

            $this->inputMappingObj((object) $result["data"][0], $this);
        }
    }

    function params()
    {
        $updateParams = $this->createParams($this, "id");
        echo $updateParams;
    }
}
