<?php

class Quest
{
    private $conn;
    private $quests_table = "quests";
    private $completed_quests_table = "completed_quests";

    public $id;
    public $name;
    public $cost;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getQuests()
    {
        $query = "SELECT * FROM {$this->quests_table}";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    public function getQuestData($quest_id)
    {
        $query = "SELECT * FROM {$this->quests_table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($quest_id));
        $stmt->bindParam(":id", $id);

        $stmt->execute();
        return $stmt;
    }

    public function create()
    {
        $query = "INSERT INTO {$this->quests_table} SET name=:name, cost=:cost";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->cost = htmlspecialchars(strip_tags($this->cost));
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":cost", $this->cost);

        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    public function getCompletedQuestsByUserId($user_id)
    {
        $query = "SELECT quest_id FROM {$this->completed_quests_table} WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        $us_id = htmlspecialchars(strip_tags($user_id));
        $stmt->bindParam(":user_id", $us_id);

        $stmt->execute();
        return $stmt;
    }

    public function setCompletedQuestByUserId($user_id, $quest_id)
    {
        $query = "INSERT INTO {$this->completed_quests_table} SET user_id = :user_id, quest_id = :quest_id";
        $stmt = $this->conn->prepare($query);

        $us_id = htmlspecialchars(strip_tags($user_id));
        $q_id = htmlspecialchars(strip_tags($quest_id));
        $stmt->bindParam(":user_id", $us_id);
        $stmt->bindParam(":quest_id", $q_id);

        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}