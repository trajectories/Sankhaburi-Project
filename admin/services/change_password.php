<?php
// Replace with your database credentials
include "../db/db.php";

// Get form data
$current_password = $_POST['current-password'];
$new_password = $_POST['new-password'];
$confirm_password = $_POST['confirm-password'];

// Check if new password matches confirm password
if ($new_password != $confirm_password) {
  echo "error";
  exit();
}

// Get user ID from session or cookie
$user_id = 1;

// Check if current password is correct
$sql = "SELECT * FROM users WHERE id='$user_id' AND password='$current_password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
  // Update password in database
  $sql = "UPDATE users SET password='$new_password' WHERE id='$user_id'";
  if (mysqli_query($conn, $sql)) {
    echo "success";
  } else {
    echo "error";
  }
} else {
  // Current password is invalid
  echo "invalid";
}

// Close connection
mysqli_close($conn);

?>
