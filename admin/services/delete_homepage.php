<?php
error_reporting(E_ALL & ~E_NOTICE);
include '../db/db.php';
$id = $_GET['id'];

if(isset($id)) {
    // Get the filename of the image associated with the data being deleted
    $stmt = $db->prepare("SELECT image FROM homepage WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    // Delete the image file
    if (!empty($image)) {
        $imageFile = str_replace( '/admin', '', $image);
        if (file_exists($imageFile)) {
            unlink($imageFile);
        }
    }
    // Delete the data from the database
    $stmt = $db->prepare("DELETE FROM homepage WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo '<script>alert("Data deleted successfully.");</script>';
        echo '<script>window.location.href = "../pages/manage.php?category_id=1";</script>';
    } else {
        echo '<script>alert("Error deleting data.");</script>';
        echo '<script>window.location.href = "../pages/manage.php?category_id=1";</script>';
    }
    $stmt->close();
}
$db->close();
?>