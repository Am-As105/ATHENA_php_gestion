<?php

class ProjectMember {
    private int $userId;
    private int $projectId;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }

    public function setProjectId(int $projectId)
    {
        $this->projectId = $projectId;
    }
}
