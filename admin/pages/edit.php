<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include '../db/db.php';

$id = $_GET['id'];

$sql = "SELECT l.id, l.name, l.description, l.short_description, l.img_1, l.location, l.map, l.tel, l.open_time, l.close_time, l.website, c.name as category_name, l.category_id FROM locations as l
LEFT JOIN category as c ON c.category_id = l.category_id WHERE l.id = '$id'";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    header("Location: ../../404.html");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $short_description = $_POST['short_description'];
    $location = $_POST['location'];
    $map = $_POST['map'];
    $tel = $_POST['tel'];
    $open_time = $_POST['open_time'];
    $close_time = $_POST['close_time'];
    $website = $_POST['website'];
    $category_id = $_POST['category_id'];

    // Check if an image is uploaded
    if (isset($_FILES['image1']) && $_FILES['image1']['error'] === UPLOAD_ERR_OK) {
        $imgFile = $_FILES['image1']['tmp_name'];
        $imgName = $_FILES['image1']['name'];

        // Generate a UUID for the image file name
        $uuid = uniqid();
        $fileExtension = pathinfo($imgName, PATHINFO_EXTENSION);
        $newFileName = 'i-' . $uuid . '-' . $fileExtension;

        $imgPath = '../uploads/' . $newFileName;

        // Move the uploaded image to the destination folder
        move_uploaded_file($imgFile, $imgPath);

        // Set the image path
        $img1 = $newFileName;
    } else {
        // No image uploaded, set $img1 to the existing image path
        $img1 = $_POST['existing_image'];
    }

    $sql = "UPDATE locations SET name=?, description=?, short_description=?, location=?, map=?, img_1=?, tel=?, open_time=?, close_time=?, website=?, category_id=? WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssssssssssi", $name, $description, $short_description, $location, $map, $img1, $tel, $open_time, $close_time, $website, $category_id, $id);

    if ($stmt->execute()) {
        // Successfully updated the record
        echo '<script>alert("Data updated successfully.");</script>';
        echo '<script>window.location.href = "../pages/view.php?id=' . $id . '";</script>';
        exit;
    } else {
        // Handle database update error
        echo '<script>alert("Error updating data.");</script>';
        echo '<script>window.location.href = "../pages/edit.php?id=' . $id . '";</script>';
        exit;
    }
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
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-2xl font-semibold text-gray-900">รายละเอียดข้อมูลสถานที่ท่องเที่ยว : <?= $row['name'] ?></h1>
            <!-- <?php echo var_dump($row); ?> -->
            <form method="POST" action="../services/update.php" enctype="multipart/form-data">
                <div class="mt-5 border-t border-gray-200">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <!-- Example for one field -->
                        <input type="text" name="id" value="<?= $row['id'] ?>" hidden>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">ชื่อ</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" name="name" value="<?= $row['name'] ?>" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">ประเภท</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <select name="category_id" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                                    <?php
                                    $categorySql = "SELECT category_id, name FROM category";
                                    $categoryResult = $db->query($categorySql);
                                    $categoryRow = $categoryResult->fetch_assoc();

                                    echo '<option value="' . $row['category_id'] . '" selected>' . $row['category_name'] . '</option>';

                                    while ($categoryRow = $categoryResult->fetch_assoc()) {
                                        if (($categoryRow['category_id'] != '6') and $categoryRow['category_id'] != '5' and $categoryRow['category_id'] != '9' and   $categoryRow['name'] != $row['category_name']) {
                                            echo '<option value="' . $categoryRow['category_id'] . '">' . $categoryRow['name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">รายละเอียด</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <textarea name="description" rows="8" cols="60" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500"><?= $row['description'] ?></textarea>
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">รายละเอียดย่อ</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <textarea name="short_description" rows="3" cols="50" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500"><?= $row['short_description'] ?></textarea>
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">รูปภาพ</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" name="existing_image" value="<?= $row['img_1'] ?>" hidden>
                                <?php if ($row['img_1'] == "") { ?>
                                    <img src="../assets/imgs/image-not-found.png" class="rounded-lg border-4 border-black-400" width="400" height="400">
                                <?php } else { ?>
                                    <img src="../uploads/<?= $row['img_1'] ?>" alt="Image 1" class="mb-3 rounded-lg" width="200" height="200">
                                <?php } ?>
                                <input type="file" name="image1" accept="image/*" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">สถานที่ตั้ง</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" name="location" value="<?= $row['location'] ?>" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">ลิ้งค์แผนที่</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" name="map" value="<?= $row['map'] ?>" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">เบอร์โทรติดต่อ</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" name="tel" value="<?= $row['tel'] ?>" pattern="0\d{8,9}" title="กรุณาใส่หมายเลขให้ถูกต้อง (ตัวอย่าง. 0812345678)" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">เวลาเปิด</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" name="open_time" value="<?= $row['open_time'] ?>" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">เวลาปิด</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" name="close_time" value="<?= $row['close_time'] ?>" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">เว็บไซต์</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" name="website" value="<?= $row['website'] ?>" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                            </dd>
                        </div>


                        <!-- Add other fields in the same manner -->
                    </dl>
                </div>
                <div class="mt-6 flex space-x-3">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>