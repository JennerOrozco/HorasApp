<?php
include_once '../config/common.php';
class Solicitudes
{
    // DB connection y table name
    public $conn;
    public $table_name = "solicitudes";
    public Common $common;

    // object properties

    public $id;
    public $nombre;
    public $apellido;
    public $compania;
    public $correo;
    public $telefono;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
        $this->common = new Common();
    }

    // read all
    function readAll()
    {
        return $this->common->read("*", "", "", $this, "");
    }


    function create()
    {
        $insertParams = "nombre,apellido,compania,correo,telefono";

        return $this->common->create($insertParams, $this);
    }
}
