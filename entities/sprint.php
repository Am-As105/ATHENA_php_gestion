<?php



class Sprint {
    private int $id;
    private string $name;
    private string $startDate;
    private string $endDate;
    private int $projectId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $date)
    {
        $this->startDate = $date;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function setEndDate(string $date)
    {
        $this->endDate = $date;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }
}
