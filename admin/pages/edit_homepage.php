<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("Please login.");</script>';
    echo '<script>window.location.href = "login.php";</script>';
}

include '../db/db.php';

$id = $_GET['id'];

$sql = "SELECT * From homepage WHERE id = '$id'";
$result = $db->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    header("Location: ../../404.html");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        // No image uploaded, set $img1 to the existing image path
        $img1 = $_POST['existing_image'];
    }

    $sql = "UPDATE homepage SET image=?, description=?, image_no=? WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssi", $img1, $description, $image_no , $id);

    if ($stmt->execute()) {
        // Successfully updated the record
        echo '<script>alert("Data updated successfully.");</script>';
        echo '<script>window.location.href = "../pages/view_homepage.php?id=' . $id . '";</script>';
        exit;
    } else {
        // Handle database update error
        echo '<script>alert("Error updating data.");</script>';
        echo '<script>window.location.href = "../pages/edit_homepage.php?id=' . $id . '";</script>';
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
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-2xl font-semibold text-gray-900">รายละเอียดข้อมูลสถานที่ท่องเที่ยว : <?= $row['name'] ?></h1>
            <!-- <?php echo var_dump($row); ?> -->
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mt-5 border-t border-gray-200">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <!-- Example for one field -->
                        <input type="text" name="id" value="<?= $row['id'] ?>" hidden>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">ประเภท</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <select name="image_no" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                                    <option value="<?= $row['image_no'] ?>" selected><?= $row['image_no'] ?></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">รูปภาพ</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" name="existing_image" value="<?= $row['image'] ?>" hidden>
                                <?php if ($row['image'] == "") { ?>
                                    <img src="../assets/imgs/image-not-found.png" class="rounded-lg border-4 border-black-400" width="400" height="400">
                                <?php } else { ?>
                                    <img src="<?= str_replace( '/admin', '', $row['image']) ?>" class="rounded-lg" width="400" height="400">
                                <?php } ?>
                                <input type="file" name="image" accept="image/*" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500">
                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                            <dt class="text-sm font-medium text-gray-500">รายละเอียด</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <textarea name="description" rows="8" cols="60" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500"><?= $row['description'] ?></textarea>
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