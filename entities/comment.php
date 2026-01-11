<?php




class Comment {
    private int $id;
    private int $userId;
    private ?int $taskId;
    private ?int $projectId;
    private string $content;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTaskId(): ?int
    {
        return $this->taskId;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }
}
