<?php
class Common{
  
    public function response($dbResponse){    
    $responseArray=array();
    $responseArray["data"]=array();
  
  
    while ($row = $dbResponse->fetch(PDO::FETCH_ASSOC)){
        $arrayItem=array();
        foreach($row As $clave => $valor){           
            $arrayItem[$clave] = $valor;           
        }
        array_push($responseArray["data"], $arrayItem);        
    }
    return $responseArray;        
    }
}
?>