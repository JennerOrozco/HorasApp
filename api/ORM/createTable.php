<?php

include_once '../common/commonInclude.php';
include_once '../common/initVariables.php';

$tableName = $argv[1] . "s";

$classPHP = file_get_contents("./class.txt");
$readPHP = file_get_contents("./read.txt");
$createPHP = file_get_contents("./create.txt");


$property = "";
$stringCreate = "";

$banderaId = false;




$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" . $tableName . "' AND TABLE_SCHEMA = '" . $db_var_db_name . "'";
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    foreach ($row as $valor) {
        $property = $property . ("\n public $" . $valor . ";");
        if ($banderaId) {
            $stringCreate = $stringCreate . $valor . ",";
        }
    }
    $banderaId = true;
}

$classPHP = str_replace("{nombreClase}", ucwords($argv[1]), $classPHP);
$classPHP = str_replace("{nombreTabla}", $tableName, $classPHP);
$classPHP = str_replace("{propiedadesClases}", $property, $classPHP);
$classPHP = str_replace("{stringClass}", $stringCreate, $classPHP);

$readPHP = str_replace("{nombreClase}", ucwords($argv[1]), $readPHP);
$readPHP = str_replace("{nombreInstancia}", $argv[1], $readPHP);

$createPHP = str_replace("{nombreClase}", ucwords($argv[1]), $createPHP);
$createPHP = str_replace("{nombreInstancia}", $argv[1], $createPHP);





mkdir("../" . $argv[1]);

file_put_contents("../objects/" . $argv[1] . '.php', $classPHP);
file_put_contents("../" . $argv[1] . '/read.php', $readPHP);
file_put_contents("../" . $argv[1] . '/create.php', $createPHP);
