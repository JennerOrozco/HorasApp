<?php

include_once '../common/commonInclude.php';

$tableName = $argv[1] . "s";
$stringPHP = "<?php";

$readPHP = "<?php";
$createPHP = "<?php";

$stringCreate = "";
$banderaId = false;


function addLineTable($text)
{
    global $stringPHP;
    $stringPHP =  $stringPHP . $text;
}

function addLineReadPHP($text)
{
    global $readPHP;
    $readPHP =  $readPHP . "\n " . $text;
}

function addLineCreatePHP($text)
{
    global $createPHP;
    $createPHP = $createPHP . "\n " . $text;
}


$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" . $tableName . "'";

$stmt = $db->prepare($query);
$stmt->execute();


addLineTable("\n");
addLineTable("\n include_once '../config/common.php';");
addLineTable("\n");
addLineTable("\n class " . ucwords($argv[1]));
addLineTable("\n {");
addLineTable("\n // DB connection y table name");
addLineTable("\n public $" . "conn;");
addLineTable("\n public $" . "table_name = '" . $argv[1]  . "s';");
addLineTable("\n public Common $" . "common;");

addLineTable("\n");
addLineTable("\n // object properties");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    foreach ($row as $valor) {
        addLineTable("\n public $" . $valor . ";");
        if ($banderaId) {
            $stringCreate = $stringCreate . $valor . ",";
        }
    }

    $banderaId = true;
}

addLineTable("\n");
addLineTable("\n // constructor with $" . "db as database connection");

addLineTable("\n public function __construct($" . "db)");
addLineTable("\n {");
addLineTable("\n $" . "this->conn = $" . "db;");
addLineTable("\n $" . "this->common = new Common();");
addLineTable("\n");

addLineTable("\n }");
addLineTable("\n");
addLineTable('// read all rows from object');

addLineTable("\n function readAll()");
addLineTable("\n {");
addLineTable('return $this->common->read("*", "", "", $this, "");');
addLineTable("\n }");

addLineTable("\n");
addLineTable("\n");


addLineTable('// create with all columns');

addLineTable("\n function create()");
addLineTable("\n {");
addLineTable("\n $" . "insertParams = '" . trim($stringCreate, ',') . "';");

addLineTable('return $this->common->create($insertParams,$this);');
addLineTable("\n }");



addLineTable("\n }");
addLineTable("\n ?>");

file_put_contents("../objects/" . $argv[1] . '.php', $stringPHP);


mkdir("../" . $argv[1]);

addLineReadPHP('header("Access-Control-Allow-Origin: *");');
addLineReadPHP('header("Content-Type: application/json; charset=UTF-8");');
addLineReadPHP("");
addLineReadPHP("include_once '../common/commonInclude.php';");
addLineReadPHP("include_once '../objects/" . $argv[1] . '.php' . "';");
addLineReadPHP("");
addLineReadPHP('$' . $argv[1] . ' = new ' . ucwords($argv[1]) . '($db);');
addLineReadPHP('$' . $argv[1] . 'Result = $' . $argv[1]  . '->readAll();');
addLineReadPHP("");

addLineReadPHP('if ($' . $argv[1] . 'Result["success"] == true) {');
addLineReadPHP('$common->response200(array("data" => $' . $argv[1] . 'Result["data"]));');
addLineReadPHP('} else {');
addLineReadPHP('$common->response404("No data found.");');
addLineReadPHP('}');
addLineReadPHP("\n ?>");

file_put_contents("../" . $argv[1] . '/read.php', $readPHP);


addLineCreatePHP('header("Access-Control-Allow-Origin: *");');
addLineCreatePHP('header("Content-Type: application/json; charset=UTF-8");');
addLineCreatePHP('header("Access-Control-Allow-Methods: POST");');
addLineCreatePHP('header("Access-Control-Max-Age: 3600");');
addLineCreatePHP('header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");');
addLineCreatePHP("");
addLineCreatePHP("include_once '../common/commonInclude.php';");
addLineCreatePHP("include_once '../objects/" . $argv[1] . '.php' . "';");
addLineCreatePHP("");
addLineCreatePHP('$' . $argv[1] . ' = new ' . ucwords($argv[1]) . '($db);');
addLineCreatePHP('$data = json_decode(file_get_contents("php://input"));');
addLineCreatePHP("");
addLineCreatePHP("// Validate input data");
addLineCreatePHP("if (){");
addLineCreatePHP('$common->inputMappingObj($data, $product);');
addLineCreatePHP('$result = $' . $argv[1] . '->create();');

addLineCreatePHP('if ($result["success"] == true) {');
addLineCreatePHP('$common->response200(array("message" => " ' . $argv[1] . ' was Created", "id" => $result["id"]));');


addLineCreatePHP('} else {');
addLineCreatePHP('$common->response503("Unable to create product.");');
addLineCreatePHP("}");
addLineCreatePHP("} else {");
addLineCreatePHP('$common->response404("Unable to create ' . $argv[1] . '. Data is incomplete.");');

addLineCreatePHP("}");
addLineCreatePHP("?>");

file_put_contents("../" . $argv[1] . '/create.php', $createPHP);
