<?php
// Database connection settings
include '../db/db.php';

// Get data from form submission
$id = $_POST["id"];
$name = $_POST["name"];
$description = $_POST["description"];
$tel = $_POST["tel"];
$map = $_POST["map"];

// SQL query to update existing attraction in database
$sql = "UPDATE attractions SET name='$name', description='$description', telephone='$tel', location_map='$map' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
  // If attraction was successfully updated in the database, return success message
  echo "success";
} else {
  // If there was an error updating the attraction, return error message
  echo "error";
}

// Close database connection
$conn->close();
