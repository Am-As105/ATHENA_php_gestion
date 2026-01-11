<?php
session_start();
require_once "../repositories/projectrepositry.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$projectRepo = new ProjectRepository();
$projects = $projectRepo->getAllByUser($_SESSION['user_id']);

if (isset($_POST['add_project'])) {
    $projectRepo->addProject($_POST['title'], $_POST['description'], $_SESSION['user_id']);
    // header("Location: dash.php");
    exit;
}

if (isset($_POST['update_project'])) {
    $projectRepo->updateProject($_POST['update_id'], $_POST['title'], $_POST['description']);
    header("Location: project.php");
    exit;
}

if (isset($_POST['delete_id'])) {
    $projectRepo->deleteProject($_POST['delete_id']);
    header("Location: project.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

<aside class="w-64 bg-green-700 text-white flex flex-col">
<div class="p-6 text-2xl font-bold">ATHENA</div>
<nav class="flex-1 px-4 space-y-2">
<a href="dash.php" class="block px-3 py-2 rounded hover:bg-green-600">Dashboard</a>
<a href="#" class="block px-3 py-2 rounded hover:bg-green-600">Projects</a>
<a href="logout.php" class="block px-3 py-2 rounded hover:bg-green-900">Logout</a>
</nav>
</aside>

<main class="flex-1 p-8 bg-white">
<h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>
  <!-- Add Project Form -->
<form method="POST" class="bg-white border p-6 rounded mb-6">
    <h2 class="font-bold mb-4 text-gray-800">Add New Project</h2>
    <input type="text" name="title" placeholder="Title" required class="border px-2 py-1 rounded w-full mb-2">
    <textarea name="description" placeholder="Description" class="border px-2 py-1 rounded w-full mb-2"></textarea>
    <button type="submit" name="add_project" class="bg-green-500 text-white px-4 py-2 rounded">Add Project</button>
</form>

<!-- Projects List -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach($projects as $project): ?>
        <div class="bg-white border p-4 rounded shadow">
            <h3 class="font-bold mb-2"><?php echo $project['title']; ?></h3>
            <p class="mb-2"><?php echo $project['description']; ?></p>

            <div class="flex space-x-2">
                <!-- Edit Form -->
                <form method="POST" class="inline">
                    <input type="hidden" name="update_id" value="<?php echo $project['id']; ?>">
                    <input type="text" name="title" value="<?php echo $project['title']; ?>" class="border px-1 py-1 rounded">
                    <input type="text" name="description" value="<?php echo $project['description']; ?>" class="border px-1 py-1 rounded">
                    <button type="submit" name="update_project" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</button>
                </form>

                <!-- Delete Form -->
                <form method="POST" class="inline">
                    <input type="hidden" name="delete_id" value="<?php echo $project['id']; ?>">
                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>


</main>
</body>
</html>
