<?php
require_once "../config/Databse.php";
require_once "../repositories/ProjectRepositry.php";
require_once "../repositories/SprintRepo.php";

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$projectRepo = new ProjectRepository();
$sprintRepo = new SprintRepository();

if (isset($_POST['add_project'])) {
    $projectRepo->addProject($_POST['title'], $_POST['description'], $userId);
    header("Location: dash.php");
    exit;
}

if (isset($_POST['update_project'])) {
    $projectRepo->updateProject($_POST['update_id'], $_POST['title'], $_POST['description']);
    header("Location: dash.php");
    exit;
}

if (isset($_POST['delete_project'])) {
    $projectRepo->deleteProject($_POST['delete_id']);
    header("Location: dash.php");
    exit;
}


if (isset($_POST['add_sprint'])) {
    $sprintRepo->addSprint(
        (int)$_POST['project_id'], 
        $_POST['name'], 
        $_POST['start_date'], 
        $_POST['end_date']
    );
    header("Location: dash.php?view_sprints=" . $_POST['project_id']);
    exit;
}

$projects = $projectRepo->getAllByUser($userId);

$editProject = null;
if (isset($_GET['edit_id'])) {
    foreach ($projects as $p) {
        if ($p->getId() == $_GET['edit_id']) {
            $editProject = $p;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATHENA - Projects Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 flex min-h-screen font-sans">

<aside class="w-64 bg-slate-900 text-white flex flex-col fixed h-full shadow-xl">
    <div class="p-6 text-2xl font-bold border-b border-slate-800 flex items-center gap-2">
        <div class="w-8 h-8 bg-emerald-500 rounded flex items-center justify-center text-sm text-white">A</div>
        <span>ATHENA</span>
    </div>
    <nav class="flex-1 p-4 space-y-2 mt-4">
        <a href="dash.php" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-800 text-emerald-400 shadow-sm">
            <i class="fas fa-columns"></i> Dashboard
        </a>
    </nav>
    <div class="p-4 border-t border-slate-800">
        <a href="logout.php" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</aside>

<main class="flex-1 ml-64 p-10">
    <header class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Project Management</h1>
            <p class="text-slate-500 mt-1">Efficiently organize your Scrum workflow.</p>
        </div>
        <a href="?action=new" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-emerald-600/20 transition-all flex items-center gap-2">
            <i class="fas fa-plus"></i> New Project
        </a>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach($projects as $project): ?>
        <div class="bg-white p-7 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-5">
                <div class="flex gap-2 bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                    <i class="fas fa-project-diagram mt-0.5"></i> Project
                </div>
                <div class="flex gap-3">
                    <a href="?edit_id=<?= $project->getId() ?>" class="text-slate-300 hover:text-blue-500 transition-colors"><i class="fas fa-pen"></i></a>
                    <form method="POST" action="dash.php" onsubmit="return confirm('Confirm deletion?')">
                        <input type="hidden" name="delete_id" value="<?= $project->getId() ?>">
                        <button type="submit" name="delete_project" class="text-slate-300 hover:text-red-500 transition-colors">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <h3 class="text-xl font-bold text-slate-900 mb-2"><?= htmlspecialchars($project->getTitle()) ?></h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3"><?= htmlspecialchars($project->getDescription()) ?></p>
            
            <div class="pt-5 border-t border-slate-50 flex flex-col gap-4">
                <div class="flex justify-between items-center">
                    <a href="?view_sprints=<?= $project->getId() ?>" class="text-xs font-bold text-emerald-600 uppercase tracking-widest hover:underline">
                        <i class="fas fa-running mr-1"></i> View Sprints
                    </a>
                    <a href="?action=new_sprint&project_id=<?= $project->getId() ?>" class="text-xs font-bold text-slate-400 hover:text-slate-900 uppercase tracking-widest">
                        + Add Sprint
                    </a>
                </div>

                <?php if (isset($_GET['view_sprints']) && $_GET['view_sprints'] == $project->getId()): ?>
                <div class="mt-2 space-y-2 bg-slate-50 p-3 rounded-xl border border-slate-100">
                    <?php 
                    // Use your repository method: getAllByProject
                    $sprints = $sprintRepo->getAllByProject($project->getId()); 
                    ?>
                    <?php if (empty($sprints)): ?>
                        <p class="text-[10px] text-slate-400 text-center italic">No sprints yet</p>
                    <?php else: ?>
                        <?php foreach($sprints as $sprint): ?>
                        <div class="flex justify-between items-center text-xs p-2 bg-white rounded-lg shadow-sm border border-slate-100">
                            <span class="font-bold text-slate-700"><?= htmlspecialchars($sprint['title']) ?></span>
                            <a href="tasks.php?sprint_id=<?= $sprint['id'] ?>" class="text-emerald-500 hover:text-emerald-700 font-bold">Tasks →</a>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if (isset($_GET['action']) && $_GET['action'] == 'new'): ?>
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-slate-900">New Project</h2>
                <a href="dash.php" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times text-xl"></i></a>
            </div>
            <form method="POST" action="dash.php" class="space-y-5">
                <input type="text" name="title" placeholder="Project Name" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                <textarea name="description" placeholder="Short Description" rows="4" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500"></textarea>
                <button type="submit" name="add_project" class="w-full bg-emerald-600 text-white py-4 rounded-xl font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-600/30 transition-all">Create Project</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['action']) && $_GET['action'] == 'new_sprint'): ?>
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-slate-900">Add Sprint</h2>
                <a href="dash.php" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times text-xl"></i></a>
            </div>
            <form method="POST" action="dash.php" class="space-y-5">
                <input type="hidden" name="project_id" value="<?= $_GET['project_id'] ?>">
                <input type="text" name="name" placeholder="Sprint Name (e.g. Sprint 1)" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-emerald-500">
                <div class="grid grid-cols-2 gap-4">
                    <input type="date" name="start_date" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                    <input type="date" name="end_date" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                </div>
                <button type="submit" name="add_sprint" class="w-full bg-slate-900 text-white py-4 rounded-xl font-bold hover:bg-emerald-600 shadow-lg transition-all">Save Sprint</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($editProject): ?>
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-8 shadow-2xl text-slate-900">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Edit Project</h2>
                <a href="dash.php" class="text-slate-400 hover:text-slate-600"><i class="fas fa-times text-xl"></i></a>
            </div>
            <form method="POST" action="dash.php" class="space-y-5">
                <input type="hidden" name="update_id" value="<?= $editProject->getId() ?>">
                <input type="text" name="title" value="<?= htmlspecialchars($editProject->getTitle()) ?>" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
                <textarea name="description" rows="4" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($editProject->getDescription()) ?></textarea>
                <button type="submit" name="update_project" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all">Save Changes</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</main>

</body>
</html>