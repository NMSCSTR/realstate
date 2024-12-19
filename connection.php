<?php

class Database
{

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbName = "realstate";
    private $mysqli = '';

    private $result = array();

    public function __construct()
    {
        $this->mysqli = mysqli_connect($this->servername, $this->username, $this->password, $this->dbName);
    }

    public function insert($table, $para)
    {
        $table_columns = implode(', ', array_keys($para));
        
        $escaped_values = array_map(array($this->mysqli, 'real_escape_string'), array_values($para));
        $table_value = implode("', '", $escaped_values);

        $sql = "INSERT INTO $table($table_columns) VALUES ('$table_value')";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function update($table, $para, $id)
    {
        $args = array();
        foreach ($para as $key => $value) {
            $args[] = "$key = '$value'";
        }

        $update_value = implode(',', $args);

        $sql = "UPDATE $table SET " . $update_value . " WHERE $id";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE $id ";
        $result = $this->mysqli->query($sql);
        return $result;
    }



    public function select($table, $rows = "*", $where = null)
    {
        if ($where != null) {
            $sql = "SELECT $rows FROM $table WHERE $where";
        } else {
            $sql = "SELECT $rows FROM $table";
        }

        $result = $this->mysqli->query($sql);
        return $result;
    }


    public function __destruct()
    {
        $this->mysqli->close();
    }
}
