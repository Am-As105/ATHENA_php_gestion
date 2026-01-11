<?php
require_once "../config/Databse.php";

class TaskRepository {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getBySprint($sprintId) {
        $stmt = $this->conn->prepare("SELECT * FROM tasks WHERE sprint_id = ?");
        $stmt->execute([$sprintId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTask($sprintId, $title, $desc, $status, $userId) {
        $stmt = $this->conn->prepare("INSERT INTO tasks (sprint_id, title, description, status, user_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$sprintId, $title, $desc, $status, $userId]);
    }

    public function updateStatus($taskId, $newStatus) {
        $stmt = $this->conn->prepare("UPDATE tasks SET status = ? WHERE id = ?");
        return $stmt->execute([$newStatus, $taskId]);
    }

    public function deleteTask($id) {
        $stmt = $this->conn->prepare("DELETE FROM tasks WHERE id = ?");
        return $stmt->execute([$id]);
    }
}