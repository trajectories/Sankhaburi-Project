<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please login.");</script>';
    echo '<script>window.location.href = "login.php";</script>';
}
include '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $image_no = $_POST['image_no'];
    $description = $_POST['description'];

    // Check if an image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imgFile = $_FILES['image']['tmp_name'];
        $imgName = $_FILES['image']['name'];
        $imgPath = '../uploads/' . $imgName;

        // Move the uploaded image to the destination folder
        move_uploaded_file($imgFile, $imgPath);

        // Set the image path
        $img1 = '../admin/uploads/' . $imgName . '';
    } else {
        // No image uploaded, set $img1 to an empty string
        $img1 = "";
    }

    // Prepare the SQL statement
    $stmt = $db->prepare("INSERT INTO homepage (image, description, image_no) VALUES (?, ?, ?)");

    // Bind the parameters to the statement
    $stmt->bind_param("sss", $img1, $description, $image_no);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<script>alert("Data added successfully.");</script>';
        echo '<script>window.location.href = "manage.php?category_id=6";</script>';

    } else {
        echo '<script>alert("Error adding data.");</script>';
        echo '<script>window.location.href = "add_homepage.php";</script>';
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
        <h1 class="text-4xl font-bold text-center mb-10">เพิ่มข้อมูลหน้าโฮมเพจ</h1>
        <form action="" method="post" enctype="multipart/form-data" class="max-w-md mx-auto bg-white p-5 rounded shadow">
            <div class="mb-5">
                <label for="image" class="block mb-2 text-sm font-medium text-gray-600">รูปภาพ</label>
                <input type="file" name="image" id="image" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
            </div>
            <div class="mb-5">
                <label for="image_no" class="block mb-2 text-sm font-medium text-gray-600">รูปภาพที่</label>
                <select name="image_no" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                    <option value="1">รูปภาพที่ 1</option>
                    <option value="2">รูปภาพที่ 2</option>
                </select>
            </div>
            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-600">รายละเอียด</label>
                <textarea name="description" id="description" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500"></textarea>
            </div>
            <button type="submit" class="w-full py-2 bg-purple-600 text-white font-bold rounded hover:bg-purple-700">เพิ่มข้อมูล</button>
        </form>
    </div>
</body>

</html>