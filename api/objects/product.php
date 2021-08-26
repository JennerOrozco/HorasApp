<?php
include_once '../config/common.php';
class Product
{
    // DB connection y table name
    private $conn;
    private $table_name = "products";
    private Common $common;

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
    function read()
    {
        $query = $this->common->createSelectQuery("*", $this->table_name, "", "1");

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }


    function create()
    {
        $insertParams = "name,price,description,category_id,created";

        $query = $this->common->createInsertQuery($this->table_name, $insertParams);

        $stmt = $this->conn->prepare($query);

        $this->common->sanitize($this, $insertParams);

        $this->common->bindParameter($stmt, $this, $insertParams);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
