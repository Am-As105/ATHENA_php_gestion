<?php
class Admin extends User {
    public function canEditTask(Task $task): bool
    {
        return true;
    }
}
