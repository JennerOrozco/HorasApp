<?php
class Common
{
    //FUNCTION SELECT
    public function createSelectQuery($fields, $table, $where, $orderBy)
    {
        if ($where == "") {
            $where = " 1 = 1";
        }
        $str = "SELECT " . $fields . " FROM " . $table . " WHERE " . $where . " ORDER BY " . $orderBy;
        return $str;
    }

    public function response($dbResponse)
    {
        $responseArray = array();
        $responseArray["data"] = array();

        while ($row = $dbResponse->fetch(PDO::FETCH_ASSOC)) {
            $arrayItem = array();
            foreach ($row as $clave => $valor) {
                $arrayItem[$clave] = $valor;
            }
            array_push($responseArray["data"], $arrayItem);
        }

        return $responseArray;
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

    //FUNCTION INSERT


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
}
