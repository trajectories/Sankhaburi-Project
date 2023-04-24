<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to login page if not logged in
  header("Location: login.php");
  exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the current password, new password, and confirm password from the form
  $current_password = $_POST['current-password'];
  $new_password = $_POST['new-password'];
  $confirm_password = $_POST['confirm-password'];

  // Validate the new password and confirm password
  if ($new_password !== $confirm_password) {
    echo 'error';
    exit();
  }

  // Get the user's ID from the session
  $user_id = $_SESSION['user_id'];

  // Connect to the database
include "../db/db.php";

  // Prepare the SQL statement to get the user's current password hash
  $stmt = $mysqli->prepare("SELECT password FROM users WHERE id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $stmt->bind_result($password_hash);
  $stmt->fetch();
  $stmt->close();

  // Verify the current password
  if (!password_verify($current_password, $password_hash)) {
    echo 'error';
    exit();
  }

  // Prepare the SQL statement to update the user's password hash
  $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");
  $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
  $stmt->bind_param("si", $new_password_hash, $user_id);
  $stmt->execute();

  // Check if the update was successful
  if ($stmt->affected_rows === 1) {
    echo 'success';
  } else {
    echo 'error';
  }

  // Close the database connection
  $mysqli->close();
}
