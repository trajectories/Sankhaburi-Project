<?php
include '../db/db.php';
$categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $shortDescription = $_POST['short_description'];
    $location = $_POST['location'];
    $map = $_POST['map'];
    $tel = $_POST['tel'];
    $openTime = $_POST['open_time'];
    $closeTime = $_POST['close_time'];
    $website = $_POST['website'];
    $categoryId = $_POST['category_id'];

    // Check if an image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imgFile = $_FILES['image']['tmp_name'];
        $imgName = $_FILES['image']['name'];
        $imgPath = '../uploads/' . $imgName;

        // Move the uploaded image to the destination folder
        move_uploaded_file($imgFile, $imgPath);

        // Set the image path
        $img1 = $imgPath;
    } else {
        // No image uploaded, set $img1 to an empty string
        $img1 = "";
    }

    // Prepare the SQL statement
    $stmt = $db->prepare("INSERT INTO locations (name, description, short_description, location, map, img_1, tel, open_time, close_time, website, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind the parameters to the statement
    $stmt->bind_param("ssssssssssi", $name, $description, $shortDescription, $location, $map, $img1, $tel, $openTime, $closeTime, $website, $categoryId);

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
        <h1 class="text-4xl font-bold text-center mb-10">เพิ่มข้อมูลสถานที่</h1>
        <form action="" method="post" enctype="multipart/form-data" class="max-w-md mx-auto bg-white p-5 rounded shadow">
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-600">ชื่อ</label>
                <input type="text" name="name" id="name" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
            </div>
            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-600">ประเภท</label>
                <select name="category_id" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
                    <?php
                    $categorySql = "SELECT category_id, name FROM category WHERE category_id = '$categoryId'";
                    $categoryResult = $db->query($categorySql);
                    $row = $categoryResult->fetch_assoc();
                    echo '<option value="' . $row['category_id'] . '" selected>' . $row['name'] . '</option>';
                    ?>
                </select>
            </div>
            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-600">รายละเอียด</label>
                <textarea name="description" id="description" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500"></textarea>
            </div>
            <div class="mb-5">
                <label for="short_description" class="block mb-2 text-sm font-medium text-gray-600">รายละเอียดย่อ</label>
                <textarea name="short_description" id="description" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500"></textarea>
            </div>
            <div class="mb-5">
                <label for="image" class="block mb-2 text-sm font-medium text-gray-600">รูปภาพ</label>
                <input type="file" name="image" id="image" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
            </div>
            <div class="mb-5">
                <label for="location" class="block mb-2 text-sm font-medium text-gray-600">สถานที่ตั้ง</label>
                <input type="text" name="location" id="location" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
            </div>
            <div class="mb-5">
                <label for="map" class="block mb-2 text-sm font-medium text-gray-600">ลิ้งค์แผนที่</label>
                <input type="text" name="map" id="location" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
            </div>
            <div class="mb-5">
                <label for="tel" class="block mb-2 text-sm font-medium text-gray-600">เบอร์โทรติดต่อ</label>
                <input type="text" name="tel" pattern="0\d{8,9}" title="กรุณาใส่หมายเลขให้ถูกต้อง (ตัวอย่าง. 0812345678)" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
            </div>
            <div class="mb-5">
                <label for="open_time" class="block mb-2 text-sm font-medium text-gray-600">เวลาเปิด</label>
                <input type="text" name="open_time" id="location" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" placeholder="ถ้าเปิด24ชั่วโมงให้กรอกช่องเวลาเปิดช่องเดียว">
            </div>
            <div class="mb-5">
                <label for="close_time" class="block mb-2 text-sm font-medium text-gray-600">เวลาปิด</label>
                <input type="text" name="close_time" id="location" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
            </div>
            <div class="mb-5">
                <label for="website" class="block mb-2 text-sm font-medium text-gray-600">เว็บไซต์</label>
                <input type="text" name="website" id="open_time" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
            </div>
            <button type="submit" class="w-full py-2 bg-purple-600 text-white font-bold rounded hover:bg-purple-700">Add Attraction</button>
        </form>
    </div>
</body>

</html>