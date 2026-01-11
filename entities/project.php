<?php
class Project {
    private int $id;
    private string $title;
    private string $description;
    private int $owner_id;

    public function getId() {
        return $this->id;
    }
    public function setId(int $id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }
    public function setTitle(string $title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }
    public function setDescription(string $description) {
        $this->description = $description;
    }

    public function getOwnerId() {
        return $this->owner_id;
    }
    public function setOwnerId(int $owner_id) {
        $this->owner_id = $owner_id;
    }
}
?>
