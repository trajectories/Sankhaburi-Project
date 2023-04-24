<?php
// Database connection settings
include '../db/db.php';

// Get data from form submission
$id = $_POST["id"];

// SQL query to delete existing attraction from database
$sql = "DELETE FROM attractions WHERE id=$id";

if ($conn->query($sql) === TRUE) {
  // If attraction was successfully deleted from the database, return success message
  echo "success";
} else {
  // If there was an error deleting the attraction, return error message
  echo "error";
}

// Close database connection
$conn->close();
?>
