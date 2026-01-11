<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require_once "../config/databse.php";

$error = "";
$success = "";


if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $database = new Database();
    $db = $database->getConnection();

    $stmt = $db->prepare("INSERT INTO users (name, email, role, password) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$name, $email, $role, $hashedPassword]);
        $success = "User enregistré avec succès";
    } catch (PDOException $e) {
        $error = "Erreur: " . $e->getMessage();
    }
}
?>
  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
        <link rel="stylesheet" href="../output.css">
</head>
<body>
    <body class="bg-gray-900 flex items-center justify-center h-screen">
  <div class="bg-gray-400 p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Register</h2>
    
    <form action="#" method="POST" class="space-y-4">
      
      <div>
        <label for="name" class="block text-gray-700">Name</label>
        <input type="text" id="name" name="name" required 
               class="w-full px-4 py-2   border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

     
      <div>
        <label for="email" class="block text-gray-700">Email</label>
        <input type="email" id="email" name="email" required 
               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      
      <div>
        <label for="role" class="block text-gray-700">Role</label>
        <select id="role" name="role" required
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
          <option value="">Select Role</option>
          <option value="user">membre d’équipe</option>
          <option value="admin">Admin</option>
          <option value="moderator">chef de projet</option>
        </select>
      </div>

      
      <div>
        <label for="password" class="block text-gray-700">Password</label>
        <input type="password" id="password" name="password" required 
               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <h6> already acount ? <a  class="" href="login.php">Login</a></p>
      </div>

       
      <div>
        <button  name="send" type="submit" 
                class="w-full bg-green-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
          Register
        </button>
      </div>
    </form>
  </div>




  <footer>
      
  </footer>
</body>



   
    

</html>