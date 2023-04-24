<?php
// Database connection settings
include '../db/db.php';

// Get data from form submission
$name = $_POST["name"];
$description = $_POST["description"];
$tel = $_POST["tel"];
$map = $_POST["map"];

// SQL query to add new attraction to database
$sql = "INSERT INTO attractions (name, description, telephone, location_map) VALUES ('$name', '$description', '$tel', '$map')";

if ($conn->query($sql) === TRUE) {
  // If attraction was successfully added to the database, return success message
  echo "success";
} else {
  // If there was an error adding the attraction, return error message
  echo "error";
}

// Close database connection
$conn->close();
?>
