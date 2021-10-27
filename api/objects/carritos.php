<?php
include_once __DIR__ . '/../common/class/crud.php';

class Carritos extends CRUD
{

    // DB connection y table name
    public $conn;
    public $table_name = "carritos";

    
 public $id;
 public $carro;
 public $moto;
 public $lancha;
 public $camion;
 public $avion;


    public function __construct($db)
    {
        $this->conn = $db;
    }


    function getAll()
    {
        return $this->_read("*", "", "", $this, "");
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

 public function getById()
 {
    return $this->_read("*", "id=", "", $this, "");
 }

 public function getByCarro()
 {
    return $this->_read("*", "carro=", "", $this, "");
 }

 public function getByMoto()
 {
    return $this->_read("*", "moto=", "", $this, "");
 }

 public function getByLancha()
 {
    return $this->_read("*", "lancha=", "", $this, "");
 }

 public function getByCamion()
 {
    return $this->_read("*", "camion=", "", $this, "");
 }

 public function getByAvion()
 {
    return $this->_read("*", "avion=", "", $this, "");
 }



    public function createCarritos()
    {
        $insertParams = "carro,moto,lancha,camion,avion";

        return $this->_create($insertParams, $this);
    }

function updateById()
{
    $updateParams = $this->createParams($this, "id,id");    

    $whereParams = "id=";

    return $this->_update($updateParams, $whereParams, $this);
}
function updateByCarro()
{
    $updateParams = $this->createParams($this, "id,carro");    

    $whereParams = "carro=";

    return $this->_update($updateParams, $whereParams, $this);
}
function updateByMoto()
{
    $updateParams = $this->createParams($this, "id,moto");    

    $whereParams = "moto=";

    return $this->_update($updateParams, $whereParams, $this);
}
function updateByLancha()
{
    $updateParams = $this->createParams($this, "id,lancha");    

    $whereParams = "lancha=";

    return $this->_update($updateParams, $whereParams, $this);
}
function updateByCamion()
{
    $updateParams = $this->createParams($this, "id,camion");    

    $whereParams = "camion=";

    return $this->_update($updateParams, $whereParams, $this);
}
function updateByAvion()
{
    $updateParams = $this->createParams($this, "id,avion");    

    $whereParams = "avion=";

    return $this->_update($updateParams, $whereParams, $this);
}


function deleteById()
{
    $whereParams = "id=";
    return $this->_delete($whereParams, $this);
}
function deleteByCarro()
{
    $whereParams = "carro=";
    return $this->_delete($whereParams, $this);
}
function deleteByMoto()
{
    $whereParams = "moto=";
    return $this->_delete($whereParams, $this);
}
function deleteByLancha()
{
    $whereParams = "lancha=";
    return $this->_delete($whereParams, $this);
}
function deleteByCamion()
{
    $whereParams = "camion=";
    return $this->_delete($whereParams, $this);
}
function deleteByAvion()
{
    $whereParams = "avion=";
    return $this->_delete($whereParams, $this);
}


}
