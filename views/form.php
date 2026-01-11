
<?php
if (isset($_POST['add_project'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $ownerId = $_SESSION['user_id'];

    $stmt = $db->prepare(
        "INSERT INTO projects (title, description, owner_id) VALUES (?, ?, ?)"
    );
    $stmt->execute([$title, $description, $ownerId]);

    header("Location: dash.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="..output.css">

</head>
<body>

    
<form method="POST" class="bg-white border border-green-200 shadow-md rounded p-6 mb-6">
  <h2 class="text-xl font-bold text-gray-800 mb-4">Add New Project</h2>

  <div class="mb-4">
    <label class="block text-gray-700 mb-1">Title</label>
    <input
      type="text"
      name="title"
      required
      class="w-full px-4 py-2 border border-green-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
    >
  </div>

  <div class="mb-4">
    <label class="block text-gray-700 mb-1">Description</label>
    <textarea
      name="description"
      rows="3"
      class="w-full px-4 py-2 border border-green-300 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
    ></textarea>
  </div>

  <button
    type="submit"
    name="add_project"
    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded"
  >
    Add Project
  </button>
</form>

    
</body>
</html>