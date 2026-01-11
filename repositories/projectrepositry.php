<?php
require_once "../config/Databse.php";
require_once "../entities/project.php";

class ProjectRepository {
    private PDO $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllByUser(int $userId): array {
        $stmt = $this->db->prepare("SELECT * FROM projects WHERE owner_id = ?");
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $projects = [];
        foreach ($rows as $row) {
            $project = new Project();
            $project->setId($row['id']);
            $project->setTitle($row['title']);
            $project->setDescription($row['description']);
            $project->setOwnerId($row['owner_id']);
            $projects[] = $project;
        }
        return $projects;
    }

    public function addProject(string $title, string $description, int $ownerId) {
        $stmt = $this->db->prepare("INSERT INTO projects (title, description, owner_id) VALUES (?, ?, ?)");
        $stmt->execute([$title, $description, $ownerId]);
    }

    public function updateProject(int $id, string $title, string $description) {
        $stmt = $this->db->prepare("UPDATE projects SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
    }

    public function deleteProject(int $id) {
        $stmt = $this->db->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
