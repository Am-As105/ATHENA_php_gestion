<?php


class Membre extends User {
    public function canEditTask(Task $task): bool
    {
        return true;
    }
}
