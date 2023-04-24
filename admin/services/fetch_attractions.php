<?php
// Database connection settings
include '../db/db.php';

// SQL query to retrieve all attractions
$sql = "SELECT * FROM attractions";
$result = $conn->query($sql);

// Check if there are any attractions
if ($result->num_rows > 0) {
  // Create HTML table to display the list of attractions
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>" . $row["description"] . "</td>";
    echo "<td>" . $row["telephone"] . "</td>";
    echo "<td>" . $row["location_map"] . "</td>";
    echo "<td>";
    echo "<button class='btn btn-sm btn-primary edit-btn' data-id='" . $row["id"] . "' data-name='" . $row["name"] . "' data-description='" . $row["description"] . "' data-tel='" . $row["telephone"] . "' data-map='" . $row["location_map"] . "'><i class='fas fa-edit'></i> Edit</button>";
    echo "<button class='btn btn-sm btn-danger delete-btn' data-id='" . $row["id"] . "'><i class='fas fa-trash'></i> Delete</button>";
    echo "</td>";
    echo "</tr>";
  }
} else {
  // If there are no attractions, display a message
  echo "<tr><td colspan='5'>No attractions found.</td></tr>";
}

// Close database connection
$conn->close();
?>
