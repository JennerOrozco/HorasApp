<?php
include_once '../config/common.php';
class Product
{
    // DB connection y table name
    public $conn;
    public $table_name = "products";
    public Common $common;

    // object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
        $this->common = new Common();
    }

    // read products
    function readProducts()
    {       
        return $this->common->read("*","","",$this,"");
    }


    function create()
    {
        $insertParams = "name,price,description,category_id,created";
        
        return $this->common->create($insertParams,$this);
    }
}
