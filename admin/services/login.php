<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Connect to MySQL database using mysqli
  include '../db/db.php';

  // Prepare and execute SQL query to check if the user exists
  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  // If the user exists, check if the password is correct
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
      // Password is correct, set session variables and redirect to dashboard
      $_SESSION["user_id"] = $row["id"];
      $_SESSION["username"] = $row["username"];
      header("Location: dashboard.php");
      exit();
    } else {
      // Password is incorrect
      $error_msg = "Incorrect password";
    }
  } else {
    // User does not exist
$error_msg = "User does not exist";
}

$stmt->close();
$conn->close();
}
