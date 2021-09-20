<?php
include_once __DIR__ . '/../common/includeCommon.php';
include_once __DIR__ . '/../common/commonVariables.php';

$tableName = $argv[1] . "s";


$classPHP = file_get_contents("./class.txt");
mkdir("../req/" . $argv[1]);


$readPHP = file_get_contents("./read.txt");
$createPHP = file_get_contents("./create.txt");


$property = "";
$stringCreate = "";
$allGetFunction = "";
$allUpdateFunction = "";
$allDeleteFunction = "";

$banderaId = false;




$query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '" .  $argv[1] . "' AND TABLE_SCHEMA = '" . $db_var_db_name . "'";

$stmt = $db->prepare($query);

$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    foreach ($row as $valor) {

        $property = $property . ("\n public $" . $valor . ";");

        $getFunction = file_get_contents("./functions/getFunction.txt");
        $getFunction = str_replace("{variableMin}", $valor, $getFunction);
        $getFunction = str_replace("{variable}", ucwords($valor), $getFunction);

        $allGetFunction = $allGetFunction . $getFunction . "\n";


        $updateFunction = file_get_contents("./functions/updateFunction.txt");
        $updateFunction = str_replace("{variableMin}", $valor, $updateFunction);
        $updateFunction = str_replace("{variable}", ucwords($valor), $updateFunction);

        $allUpdateFunction = $allUpdateFunction . $updateFunction . "\n";


        $deleteFunction = file_get_contents("./functions/deleteFunction.txt");
        $deleteFunction = str_replace("{variableMin}", $valor, $deleteFunction);
        $deleteFunction = str_replace("{variable}", ucwords($valor), $deleteFunction);

        $allDeleteFunction = $allDeleteFunction . $deleteFunction . "\n";

        $deleteFile = file_get_contents("./delete.txt");
        $deleteFile = str_replace("{nombreClase}", ucwords($argv[1]), $deleteFile);
        $deleteFile = str_replace("{nombreInstancia}", $argv[1], $deleteFile);
        $deleteFile = str_replace("{variable}", ucwords($valor), $deleteFile);

        file_put_contents("../req/" . $argv[1] . '/deleteBy' . ucwords($valor) . '.php', $deleteFile);


        $readFile = file_get_contents("./readBy.txt");
        $readFile = str_replace("{nombreClase}", ucwords($argv[1]), $readFile);
        $readFile = str_replace("{nombreInstancia}", $argv[1], $readFile);
        $readFile = str_replace("{variable}", ucwords($valor), $readFile);
        $readFile = str_replace("{variableMin}", $valor, $readFile);

        file_put_contents("../req/" . $argv[1] . '/readBy' . ucwords($valor) . '.php', $readFile);


        $updateFile = file_get_contents("./update.txt");
        $updateFile = str_replace("{nombreClase}", ucwords($argv[1]), $updateFile);
        $updateFile = str_replace("{nombreInstancia}", $argv[1], $updateFile);
        $updateFile = str_replace("{variable}", ucwords($valor), $updateFile);

        file_put_contents("../req/" . $argv[1] . '/updateBy' . ucwords($valor) . '.php', $updateFile);



        if ($banderaId) {
            $stringCreate = $stringCreate . $valor . ",";
        }
    }
    $banderaId = true;
}

$stringCreate = rtrim($stringCreate, ",");

$classPHP = str_replace("{propiedadesClases}", $property, $classPHP);
$classPHP = str_replace("{getFunctionsSection}", $allGetFunction, $classPHP);
$classPHP = str_replace("{stringInsert}", $stringCreate, $classPHP);
$classPHP = str_replace("{nombreClase}", ucwords($argv[1]), $classPHP);
$classPHP = str_replace("{nombreTabla}", $argv[1], $classPHP);
$classPHP = str_replace("{updateFunctionsSection}", $allUpdateFunction, $classPHP);
$classPHP = str_replace("{deleteFunctionsSection}", $allDeleteFunction, $classPHP);





$readPHP = str_replace("{nombreClase}", ucwords($argv[1]), $readPHP);
$readPHP = str_replace("{nombreInstancia}", $argv[1], $readPHP);

$createPHP = str_replace("{nombreClase}", ucwords($argv[1]), $createPHP);
$createPHP = str_replace("{nombreInstancia}", $argv[1], $createPHP);
$createPHP = str_replace("{stringInsert}", $stringCreate, $createPHP);



file_put_contents("../req/" . $argv[1] . '/read.php', $readPHP);
file_put_contents("../req/" . $argv[1] . '/create.php', $createPHP);





file_put_contents("../objects/" . $argv[1] . '.php', $classPHP);
