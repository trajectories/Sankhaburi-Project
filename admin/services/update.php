<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../db/db.php';

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
        $newFileName = 'i-'.$uuid . '-' . $fileExtension;

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

$db->close();
?>
