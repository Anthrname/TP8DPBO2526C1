<?php
/**
 * Class DB - Database Connection & Query Wrapper
 * Arsitektur MVC Praktikum DPBO
 */

class DB {
    private $hostname;
    private $username;
    private $password;
    private $dbname;
    private $conn;
    private $result;

    function __construct($hostname, $username, $password, $dbname) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    function open() {
        $this->conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);
        if (!$this->conn) {
            die("Koneksi Database Gagal: " . mysqli_connect_error());
        }
    }

    function execute($query) {
        $this->result = mysqli_query($this->conn, $query);
        return $this->result;
    }

    function getResult() {
        if ($this->result) {
            return mysqli_fetch_array($this->result, MYSQLI_ASSOC);
        }
        return false;
    }

    function close() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
?>
