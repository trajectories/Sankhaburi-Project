<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please login.");</script>';
    echo '<script>window.location.href = "login.php";</script>';
}
include '../db/db.php';
$categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $categoryId = $_POST['category_id'];

    // Prepare the SQL statement
    $stmt = $db->prepare("INSERT INTO category (name, category_id) VALUES (?, ?)");

    // Bind the parameters to the statement
    $stmt->bind_param("ss", $name, $categoryId);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<script>alert("Data added successfully.");</script>';
        echo '<script>window.location.href = "add.php";</script>';
    } else {
        echo '<script>alert("Error adding data.");</script>';
        echo '<script>window.location.href = "add.php";</script>';
    }
    // Close the statement and the database connection
    $stmt->close();
    
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
        <h1 class="text-4xl font-bold text-center mb-10">เพิ่มข้อมูลประเภทสถานที่</h1>
        <form action="" method="post" class="max-w-md mx-auto bg-white p-5 rounded shadow">
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-600">ชื่อประเภท</label>
                <input type="text" name="name" id="name" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
            </div>
            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-600">หมายเลขประเภท</label>
                <input type="text" name="category_id" id="category_id" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
            </div>
            <button type="submit" class="w-full py-2 bg-purple-600 text-white font-bold rounded hover:bg-purple-700">Add Attraction</button>
        </form>
    </div>
</body>

</html>