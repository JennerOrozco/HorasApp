
<?php
include_once __DIR__ . './response.php';

class Common extends Response
{
    public function validateInput($input, $stringList)
    {
        $list = explode(",", $stringList);

        foreach ($list as $valor) {

            if (!isset($input->$valor)) {
                return false;
            } else {

                if (empty($input->$valor)) {

                    return false;
                }
            }
        }

        return true;
    }


    public function validateStatus()
    {
        $arg_list = func_get_args();
        foreach ($arg_list as $item) {
            if ($item["status"] == false) {
                return false;
            }
        }
        return true;
    }

    public function prepareAndBind($query, $clase, $whereParams)
    {
        $stmt = $clase->conn->prepare($query);

        $whereParams = $this->sanitize($clase, $whereParams);

        $this->bindParameter($stmt, $clase, $whereParams);

        return $stmt;
    }

    public function prepareAndExecute($query, $clase, $whereParams)
    {
        $stmt = $this->prepareAndBind($query, $clase, $whereParams);

        if ($stmt->execute()) {

            return array("status" => true, "id" => $clase->id);
        } else {

            return array("status" => false, "id" => 0);
        }
    }



    public function abstractMessage($response)
    {
        return $response["message"];
    }



    public function bindParameterPersonalizado($stmt, $parameters)
    {
        foreach ($parameters as $clave => $valor) {

            $stmt->bindParam(":" . $clave, $valor);
        }
    }



    public function returnResponse($stmt)
    {
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {

            $returnData = $this->statementMappingArray($stmt);

            return array("status" => true, "data" => $returnData);
        } else {

            return array("status" => false, "data" => "");
        }
    }

    public function concatenarBind($variable, $param)
    {
        $arrayParam = explode(",", $param);

        foreach ($arrayParam as $valor) {

            $signEqual = explode("=", $valor);

            $signMore = explode(">", $valor);

            $signLess = explode("<", $valor);

            if (count($signEqual) == 2) {

                $variable = $variable .  $signEqual[0] . "=:" . $signEqual[0] . ", ";;
            } else if (count($signMore) == 2) {

                $variable = $variable .  $signEqual[0] . ">:" . $signEqual[0] . ", ";;
            } else if (count($signLess) == 2) {

                $variable = $variable .  $signEqual[0] . "<:" . $signEqual[0] . ", ";;
            } else {

                $variable = $variable .  $valor . "=:" . $valor . ", ";;
            }
        }

        return rtrim($variable, ", ");
    }


    public function responseToObject($variables, $class)
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
        foreach ($data as $clave => $valor) {

            if (property_exists($class, $clave)) {

                $class->$clave = $data->$clave;
            }
        }
    }

    public function sanitize($class, $parameters)
    {
        $parameters = str_replace("=", "", $parameters);

        $parameters = str_replace(">", "", $parameters);

        $parameters = str_replace("<", "", $parameters);

        $parameterArray = explode(",", $parameters);

        foreach ($parameterArray as $valor) {

            $class->$valor = htmlspecialchars(strip_tags($class->$valor));
        }

        return $parameters;
    }

    public function bindParameter($stmt, $class, $parameters)
    {
        $parameterArray = explode(",", $parameters);

        foreach ($parameterArray as $valor) {

            $stmt->bindParam(":" . $valor, $class->$valor);
        }
    }

    public function createParams($class, $noAdd = "")
    {
        $get = get_object_vars($class);

        $str = "'";

        foreach ($get as $name => $value) {

            if (!($name == "table_name" || $name == "conn" || $name == $noAdd)) {

                if (!(is_null($value))) {
                    $str = $str . $name . ",";
                }
            }
        }

        $str = rtrim($str, ",");

        $str = $str . "'";

        return $str;
    }
}
