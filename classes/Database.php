<?php

class Database {

    private $mysql_server = "localhost";
    private $mysql_user = "root";
    private $mysql_password = "";
    private $mysql_base = "195760-yeticave";

    public function connectData() {
        $connection = mysqli_connect($this->mysql_server, $this->mysql_user, $this->mysql_password, $this->mysql_base);
        if ($connection == false) {
            return mysqli_connect_error();
        } else {
            return $connection;
        }
    }

    public function selectData($sql, $arguments) {
        $connection = $this->connectData();
        $stmt = db_get_prepare_stmt($connection, $sql, $arguments);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        $data = mysqli_fetch_all($result, MYSQLI_NUM);
        mysqli_close($connection);
        return $data;
    }

    public function insertData($sql, $arguments) {
        $connection = $this->connectData();
        $stmt = db_get_prepare_stmt($connection, $sql, $arguments);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $result = mysqli_stmt_insert_id($stmt); 
        mysqli_stmt_close($stmt);
        mysqli_close($connection);
        return $result;    
    }

    public function updateData($table, $changes_data, $conditions_data) {
        $connection = $this->connectData();
        $sql = "UPDATE ".$table." SET ";
        foreach ($changes_data as $key => $value) {
            $arguments[] = $changes_data[$key][key($value)];
            $sql .= key($value)." = ?";
            if ($key < count($changes_data) - 1) $sql .= ", ";
        }
        $sql .= " WHERE ".key($conditions_data)." = ?;";
        $arguments[] = $conditions_data[key($conditions_data)];
        $stmt = db_get_prepare_stmt($connection, $sql, $arguments);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($connection);   
        return $result;    
    }
}
?>