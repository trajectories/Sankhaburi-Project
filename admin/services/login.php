<?php
session_start();
// Connect to MySQL database using mysqli
include '../db/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Prepare and execute SQL query to check if the user exists
  $stmt = $db->prepare("SELECT * FROM user WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  // If the user exists, check if the password is correct
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
      $_SESSION["user_id"] = $row["id"];
      $_SESSION["username"] = $row["username"];
      echo '<script>alert("Login successful");</script>';
      echo '<script>window.location.href = "../pages/manage.php?category_id=1";</script>';
      exit();
    } else {
      // Password is incorrect
      echo '<script>alert("Incorrect password");</script>';
    }

  } else {
    // User does not exist
    echo '<script>alert("User does not exist");</script>';
  }

  $stmt->close();
  $db->close();
}
