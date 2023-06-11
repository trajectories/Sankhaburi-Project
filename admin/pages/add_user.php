<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please login.");</script>';
    echo '<script>window.location.href = "login.php";</script>';
}
include '../db/db.php';
$categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query for inserting a new user into the database
    $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        // Successfully inserted the user
        echo '<script>alert("User added successfully.");</script>';
        echo '<script>window.location.href = "../pages/manage.php?category_id=9";</script>';
        exit;
    } else {
        // Handle database insert error
        echo '<script>alert("Error adding user.");</script>';
        echo '<script>window.location.href = "../pages/add_user.php";</script>';
        exit;
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Attraction Management</title>
</head>

<body class="bg-gray-100">
    <?php include 'header.php'; ?>
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-bold text-center mb-10">เพิ่มข้อมูลผู้ใช้งาน</h1>
        <form action="" method="post" class="max-w-md mx-auto bg-white p-5 rounded shadow">
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>
                <input type="email" name="email" id="email" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
            </div>
            <div class="mb-5">
                <label for="username" class="block mb-2 text-sm font-medium text-gray-600">Username</label>
                <input type="text" name="username" id="username" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Password</label>
                <input type="password" name="password" id="password" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
            </div>
            <button type="submit" class="w-full py-2 bg-purple-600 text-white font-bold rounded hover:bg-purple-700">Add Attraction</button>
        </form>
    </div>
</body>

</html>