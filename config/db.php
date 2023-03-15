<?php

class db {
  private $host = "localhost";
  private $username = "root";
  private $password = "";
  private $dbname = "campusphere";
  private $conn;

  public function __construct() {
  }

  public function getConnection() {
    if (!$this->conn) {
      try {
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
      }
    }
    return $this->conn;
  }
}
