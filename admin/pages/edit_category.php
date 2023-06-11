<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please login.");</script>';
    echo '<script>window.location.href = "login.php";</script>';
}
include '../db/db.php';

$id = $_GET['id'];

$sql = "SELECT * from category WHERE id = '$id'";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    header("Location: ../../404.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    // Query for updating data in the database
    $sql = "UPDATE category SET name=?, category_id=? WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssi", $name, $category_id, $id);

    if ($stmt->execute()) {
        // Successfully updated the record
        echo '<script>alert("Data updated successfully.");</script>';
        echo '<script>window.location.href = "../pages/view_category.php?id=' . $id . '";</script>';
        exit;
    } else {
        // Handle database update error
        echo '<script>alert("Error updating data.");</script>';
        echo '<script>window.location.href = "../pages/edit_category.php?id=' . $id . '";</script>';
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Attraction Management</title>
</head>

<body class="bg-gray-100">
    <?php include 'header.php'; ?>
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-bold text-center mb-10">แก้ไขข้อมูลประเภทสถานที่</h1>
        <form method="POST" action="" class="max-w-md mx-auto bg-white p-5 rounded shadow">
            <input type="text" name="id" value="<?= $row['id'] ?>" hidden>
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-600">ชื่อประเภท</label>
                <input type="text" value="<?= $row['name'] ?>" name="name" id="name" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
            </div>
            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-600">หมายเลขประเภท</label>
                <input type="text" value="<?= $row['category_id'] ?>" name="category_id" id="category_id" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
            </div>
            <button type="submit" class="w-full py-2 bg-purple-600 text-white font-bold rounded hover:bg-purple-700">ยืนยัน</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>