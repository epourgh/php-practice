<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/Database.php");

class Query
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    function noTableQuery()
    {
        $data = [
            'query' => 'Route is missing.'
        ];
        return $data;
    }

    function query($requestMethod, $table, $id, $params)
    {
        if (count($params) == 0) {
            echo '$params is empty';
        }
        if ($id == '') {
            echo '$id is empty';
        }

        echo $requestMethod;

        switch ($requestMethod) {
            case ('GET'):
                $query = $this->get($table, $id, $params);
                break;
            case ('POST'):
                $query = $this->post($table, $id, $params);
                break;
            case ('PUT'):
                $query = $this->put($table, $id, $params);
                break;
            case ('DELETE'):
                $query = $this->delete($table, $id);
                break;
        }

        $this->db->query($query);

        $rows = ($this->isQueryingId($table, $id)) ? $this->db->fetch() : $this->db->fetchAll();

        $data = [
            'users' => $rows
        ];
        return $data;
    }

    function get($table, $id, $params)
    {
        if ($this->isQueryingId($table, $id)) {
            $table = $table . 's WHERE id=' . $id;
        }

        $query = 'SELECT * FROM ' . $table . ';';
        return $query;
    }

    function post($table, $id, $params)
    {
        $query = "INSERT INTO {$table}s (";

        $i = 0;
        foreach ($params as $key => $value) {
            $i++;
            $query .= "{$key}";
            $query .= ($i !== count($params)) ? ", " : " ";
        }

        $query .= ') VALUES (';

        $i = 0;
        foreach ($params as $key => $value) {
            $i++;
            $query .= "'{$value}'";
            $query .= ($i !== count($params)) ? ", " : " ";
        }

        $query .= ");";

        return $query;
    }

    function put($table, $id, $params)
    {
        $query = "UPDATE {$table}s SET ";

        $i = 0;

        foreach ($params as $key => $value) {
            $i++;
            $query .= "{$key} = '{$value}'";
            $query .= ($i !== count($params)) ? ", " : " ";
        }

        $query .= "WHERE id={$id};";

        return $query;
    }

    function delete($table, $id)
    {
        $query = 'DELETE FROM ' . $table . 's WHERE id=' . $id;
        return $query;
    }

    function isQueryingId($table, $id)
    {
        return (substr($table, -1) != 's' && $id != '');
    }
}
