<?php
class Common
{
    //FUNCTION SELECT
    public function createSelectQuery($fields, $table, $where, $orderBy,$limit)
    {
        if ($where == "") {
            $where = " 1 = 1";
        }

        if ($orderBy != "") {
            $orderBy = " ORDER BY " . $orderBy;
        }
        $str = "SELECT " . $fields . " FROM " . $table . " WHERE " . $where . $orderBy . $limit;
        return $str;
    }

    public function objectToResponse($variables, $class)
    {
        $variablesArray = explode(",", $variables);
        $responseArray = array();

        foreach ($variablesArray as $valor) {
            $responseArray[$valor] = $class->$valor;
        }
        return $responseArray;
    }

    public function statementMappingArray($dbResponse)
    {
        $responseArray = array();        

        while ($row = $dbResponse->fetch(PDO::FETCH_ASSOC)) {
            $arrayItem = array();
            foreach ($row as $clave => $valor) {
                $arrayItem[$clave] = $valor;
            }
            array_push($responseArray, $arrayItem);
        }

        return $responseArray;
    }

    public function statementMappingObj($dbResponse, $class)
    {
        $num = $dbResponse->rowCount();
        if ($num > 0) {

            $row = $dbResponse->fetch(PDO::FETCH_ASSOC);

            foreach ($row as $clave => $valor) {
                $class->$clave = $valor;
            }
            return true;
        }
        return false;
    }

    public function inputMappingObj($data, $class)
    {
        
        foreach ($data as $clave=>$valor) {
            try {                
                $class->$clave = $data->$clave;
            } catch (Exception $e) {
            }
        }
    }

    public function response200($Response)
    {
        http_response_code(200);
        echo json_encode($Response);
    }

    public function response404($message)
    {
        http_response_code(404);
        echo json_encode(
            array("message" => $message)
        );
    }

    public function response503($message)
    {
        http_response_code(503);
        echo json_encode(
            array("message" => $message)
        );
    }

    //FUNCTION FOR INSERT


    public function createInsertQuery($table, $parameters)
    {
        $str = "INSERT INTO " . $table . " SET ";
        $parameterArray = explode(",", $parameters);

        foreach ($parameterArray as $valor) {
            $str = $str . $valor . "=:" . $valor . ", ";
        }

        return substr($str, 0, -2);
    }

    public function sanitize($class, $parameters)
    {
        $parameterArray = explode(",", $parameters);

        foreach ($parameterArray as $valor) {

            $class->$valor = htmlspecialchars(strip_tags($class->$valor));
        }
    }

    public function bindParameter($stmt, $class, $parameters)
    {
        $parameterArray = explode(",", $parameters);

        foreach ($parameterArray as $valor) {

            $stmt->bindParam(":" . $valor, $class->$valor);
        }
    }

    
    //CRUD FUNCTIONS
    function read($select,$where,$order,$clase,$limit)
    {
        if ($where != ""){
            $whereArray = explode(",", $where);            
            $newWhere = "";
            foreach ($whereArray as $valor) {
                $newWhere = $newWhere . $valor . "=:" . $valor . ", ";
            }
            $newWhere = substr($newWhere, 0, -2);
        }

        $query = $this->createSelectQuery($select, $clase->table_name, $newWhere, $order,$limit);        
        
        $stmt = $clase->conn->prepare($query);

        if ($where != ""){
            $this->sanitize($clase, $where);

            $this->bindParameter($stmt, $clase, $where);
        }

        $stmt->execute();

        $num = $stmt->rowCount();
        
        if ($num > 0) {
            $returnData = $this->statementMappingArray($stmt);            
            return array("success" => true, "data"=>$returnData);            
        
        } else {
            return array("success" => false, "data"=>"");            
        }
    }

    function create($insertParams,$clase)
    {
        $query = $this->createInsertQuery($clase->table_name, $insertParams);

        $stmt = $clase->conn->prepare($query);

        $this->sanitize($clase, $insertParams);

        $this->bindParameter($stmt, $clase, $insertParams);

        if ($stmt->execute()) {            
            return array("success" => true, "id"=>$clase->conn->lastInsertId());            
        }
        return array("success" => false, "id"=>0);
    }


    function readPersonalizado($select,$clase,$arrayParameter)
    {
        
        $query = $select;        
        
        $stmt = $clase->conn->prepare($query);                

        $this->bindParameterPersonalizado($stmt, $arrayParameter);
        

        $stmt->execute();

        $num = $stmt->rowCount();
        
        if ($num > 0) {
            $returnData = $this->statementMappingArray($stmt);            
            return array("success" => true, "data"=>$returnData);          
        
        } else {
            return array("success" => false, "data"=>"");            
        }
    }

    public function bindParameterPersonalizado($stmt, $parameters)
    {
        foreach ($parameters as $clave => $valor) {

            $stmt->bindParam(":" . $clave, $valor);
        }
    }



}
