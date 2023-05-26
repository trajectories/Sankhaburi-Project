<?php

include '../db/db.php';
$id = $_GET['id'];

if(isset($id)) {
    $stmt = $db->prepare("DELETE FROM category WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo '<script>alert("Data deleted successfully.");</script>';
        echo '<script>window.location.href = "../pages/manage.php?category_id=6";</script>';
    } else {
        echo '<script>alert("Error deleting data.");</script>';
        echo '<script>window.location.href = "../pages/manage.php?category_id=6";</script>';
    }
    $stmt->close();
}
$db->close();
?>
