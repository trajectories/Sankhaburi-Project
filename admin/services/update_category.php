<?php
include '../db/db.php';

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
        echo '<script>window.location.href = "../pages/view_category.php?id='.$id.'";</script>';
        exit;
    } else {
        // Handle database update error
        echo '<script>alert("Error updating data.");</script>';
        echo '<script>window.location.href = "../pages/edit_category.php?id='.$id.'";</script>';
        exit;
    }
    $stmt->close();
}
$db->close();
?>
