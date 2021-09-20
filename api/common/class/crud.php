<?php
include_once __DIR__ . './common.php';

class CRUD extends Common
{
    // READ

    public function createSelectQuery($fields, $table, $where, $orderBy, $limit)
    {
        $str = "";

        if (!empty($where)) {

            $where =  $this->concatenarBind($str, $where);
        } else {

            $where = " 1 = 1";
        }

        if (!empty($orderBy)) {

            $orderBy = " ORDER BY " . $orderBy;
        }

        $str = "SELECT " . $fields . " FROM " . $table . " WHERE " . $where . $orderBy . $limit;

        return $str;
    }


    function _read($select, $where, $order, $clase, $limit)
    {

        $query = $this->createSelectQuery($select, $clase->table_name, $where, $order, $limit);

        $stmt = $clase->conn->prepare($query);

        if (!empty($where)) {

            $stmt = $this->prepareAndBind($query, $clase, $where);
        }

        return $this->returnResponse($stmt);
    }


    //SELECT PERSONALIZADO

    function readPersonalizado($select, $clase, $arrayParameter)
    {

        $stmt = $clase->conn->prepare($select);

        $this->bindParameterPersonalizado($stmt, $arrayParameter);

        return $this->returnResponse($stmt);
    }

    public function bindParameterPersonalizado($stmt, $parameters)
    {
        foreach ($parameters as $clave => $valor) {

            $stmt->bindParam(":" . $clave, $valor);
        }
    }



    //FUNCTION INSERT

    public function createInsertQuery($table, $parameters)
    {
        $str = "INSERT INTO " . $table . " SET ";

        $str =  $this->concatenarBind($str, $parameters);

        return $str;
    }

    function _create($insertParams, $clase)
    {
        $query = $this->createInsertQuery($clase->table_name, $insertParams);

        $response = $this->prepareAndExecute($query, $clase, $insertParams);

        $response["id"] = $clase->conn->lastInsertId();

        return $response;
    }


    //FUNCTION UPDATE

    public function createUpdateQuery($table, $updateFields, $whereFields)
    {
        $str = "UPDATE " . $table . " SET ";

        $str = $this->concatenarBind($str, $updateFields);

        $str = rtrim($str, ", ") . " WHERE ";

        $str = $this->concatenarBind($str, $whereFields);

        return $str;
    }

    function _update($updateParams, $whereParams, $clase)
    {
        $allParams = $updateParams . "," . $whereParams;

        $query = $this->createUpdateQuery($clase->table_name, $updateParams, $whereParams);

        return $this->prepareAndExecute($query, $clase, $allParams);
    }


    //FUNCTION DELETE



    public function createDeleteQuery($table, $whereFields)
    {
        $str = "DELETE FROM " . $table . " WHERE ";

        $str = $this->concatenarBind($str, $whereFields);

        return $str;
    }

    function _delete($whereParams, $clase)
    {

        $query = $this->createDeleteQuery($clase->table_name, $whereParams);

        return $this->prepareAndExecute($query, $clase, $whereParams);
    }
}
