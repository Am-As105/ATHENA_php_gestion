
<?php

class ChefProjet extends User {
    public function canEditTask(Task $task): bool
    {
        return true;
    }
}
