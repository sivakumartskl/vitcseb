<?php

require_once (__DIR__ . '/../config.php');

class DBConnection {

    // Constructor function to connect to the database.
    public function __construct() {
        $this->conn = new PDO('mysql:host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE .
                ';charset=utf8', DB_USER, DB_PASSWORD);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Function to return the single query result
    public function getResult($selectQuery, $array) {
        $stmt = $this->conn->prepare($selectQuery);
        foreach ($array as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return ($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // Function to return the multiple query result;
    public function getResults($selectQuery, $array) {
        $stmt = $this->conn->prepare($selectQuery);
        foreach ($array as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    // Function to execute insert,delete and update statements and it returns the row count.
    public function executeQuery($query, $parameters) {
        $stmt = $this->conn->prepare($query);
        foreach ($parameters as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function executeQueryLastInsertedId($query, $parameters) {
        $stmt = $this->conn->prepare($query);
        foreach ($parameters as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function getData($query) {
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
