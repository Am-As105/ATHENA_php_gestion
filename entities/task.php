
<?php


class Task {
    private int $id;
    private string $title;
    private string $status;
    private int $assignedTo;
    private int $createdBy;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function getAssignedTo(): int
    {
        return $this->assignedTo;
    }

    public function setAssignedTo(int $userId)
    {
        $this->assignedTo = $userId;
    }

    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }
}
