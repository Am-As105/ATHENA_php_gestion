<?php
require_once "../config/Databse.php";
require_once "../repositories/TaskRepositry.php";

session_start();
if (!isset($_SESSION['user_id']) || !isset($_GET['sprint_id'])) {
    header("Location: dash.php");
    exit;
}

$sprintId = $_GET['sprint_id'];
$taskRepo = new TaskRepository();

if (isset($_POST['add_task'])) {
    $taskRepo->addTask($sprintId, $_POST['title'], $_POST['desc'], 'todo', $_SESSION['user_id']);
    header("Location: tasks.php?sprint_id=" . $sprintId);
    exit;
}

if (isset($_GET['move_to']) && isset($_GET['task_id'])) {
    $taskRepo->updateStatus($_GET['task_id'], $_GET['move_to']);
    header("Location: tasks.php?sprint_id=" . $sprintId);
    exit;
}

$tasks = $taskRepo->getBySprint($sprintId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks - Kanban Board</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-100 p-10 font-sans">

    <div class="flex justify-between items-center mb-10">
        <h1 class="text-2xl font-black text-slate-800 uppercase">Sprint Tasks</h1>
        <a href="dash.php" class="text-slate-500 hover:text-slate-800"><i class="fas fa-chevron-left"></i> Back</a>
    </div>

    <form method="POST" class="bg-white p-6 rounded-2xl shadow-sm mb-10 flex gap-4">
        <input type="text" name="title" placeholder="Task Title" required class="flex-1 p-3 bg-slate-50 border rounded-xl outline-none">
        <input type="text" name="desc" placeholder="Description" class="flex-1 p-3 bg-slate-50 border rounded-xl outline-none">
        <button type="submit" name="add_task" class="bg-emerald-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-emerald-600 transition-all">Add Task</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php 
        $cols = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'];
        foreach($cols as $status => $label): 
        ?>
        <div class="bg-slate-200/50 p-5 rounded-3xl min-h-[500px]">
            <h2 class="font-bold text-slate-600 mb-5 uppercase text-sm tracking-widest text-center"><?= $label ?></h2>
            
            <div class="space-y-4">
                <?php foreach($tasks as $task): if($task['status'] == $status): ?>
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200">
                    <h3 class="font-bold text-slate-800 mb-1"><?= htmlspecialchars($task['title']) ?></h3>
                    <p class="text-xs text-slate-500 mb-4"><?= htmlspecialchars($task['description']) ?></p>
                    
                    <div class="flex justify-between border-t pt-3">
                        <?php if($status != 'todo'): ?>
                            <a href="?sprint_id=<?= $sprintId ?>&task_id=<?= $task['id'] ?>&move_to=todo" class="text-blue-500 text-xs font-bold">ToDo</a>
                        <?php endif; ?>
                        
                        <?php if($status != 'in_progress'): ?>
                            <a href="?sprint_id=<?= $sprintId ?>&task_id=<?= $task['id'] ?>&move_to=in_progress" class="text-amber-500 text-xs font-bold">Doing</a>
                        <?php endif; ?>

                        <?php if($status != 'done'): ?>
                            <a href="?sprint_id=<?= $sprintId ?>&task_id=<?= $task['id'] ?>&move_to=done" class="text-emerald-500 text-xs font-bold">Done</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</body>
</html>