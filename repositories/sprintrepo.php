<?php
require_once "../config/Databse.php";

class SprintRepository {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getAllByProject($projectId) {
        $stmt = $this->conn->prepare("SELECT * FROM sprints WHERE project_id = ?");
        $stmt->execute([$projectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSprint($projectId, $title, $startDate, $endDate) {
        $stmt = $this->conn->prepare("INSERT INTO sprints (project_id, title, start_date, end_date) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$projectId, $title, $startDate, $endDate]);
    }

    public function deleteSprint($id) {
        $stmt = $this->conn->prepare("DELETE FROM sprints WHERE id = ?");
        return $stmt->execute([$id]);
    }
}