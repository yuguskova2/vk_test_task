<?php

class User
{
    private $conn;
    private $users_table = "users";

    public $id;
    public $name;
    public $balance;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getUsers()
    {
        $query = "SELECT * FROM {$this->users_table}";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    function create()
    {
        $query = "INSERT INTO {$this->users_table} SET name=:name, balance=:balance";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->balance = htmlspecialchars(strip_tags($this->balance));
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":balance", $this->balance);

        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    function getUserData($user_id)
    {
        $query = "SELECT * FROM {$this->users_table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $id = htmlspecialchars(strip_tags($user_id));
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        return $stmt;
    }

    function updateUserBalance($user_id, $balance)
    {
        $query = "UPDATE {$this->users_table} SET balance = :balance WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($user_id));
        $balance = htmlspecialchars(strip_tags($balance));
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":balance", $balance);

        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}