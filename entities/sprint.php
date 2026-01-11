<?php
class Sprint {
    private int $id;
    private string $title;
    private string $start_date;
    private string $end_date;
    private int $project_id;

    public function getId() { return $this->id; }
    public function setId(int $id) { $this->id = $id; }

    public function getTitle() { return $this->title; }
    public function setTitle(string $title) { $this->title = $title; }

    public function getStartDate() { return $this->start_date; }
    public function setStartDate(string $start_date) { $this->start_date = $start_date; }

    public function getEndDate() { return $this->end_date; }
    public function setEndDate(string $end_date) { $this->end_date = $end_date; }

    public function getProjectId() { return $this->project_id; }
    public function setProjectId(int $project_id) { $this->project_id = $project_id; }
}
?>
