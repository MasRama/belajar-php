<?php

class DatabaseConnection {
    private $servername;
    private $database;
    private $username;
    private $password;
    private $conn;

    public function __construct($servername, $database, $username, $password) {
        $this->servername = $servername;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect() {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
        if (!$this->conn) {
            die("Koneksi Gagal : " . mysqli_connect_error());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        mysqli_close($this->conn);
    }
}

$servername = "localhost";
$database = "pos_shop";
$username = "root";
$password = "";

$databaseConnection = new DatabaseConnection($servername, $database, $username, $password);
$databaseConnection->connect();

?>