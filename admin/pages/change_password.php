<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  echo '<script>alert("Please login.");</script>';
  echo '<script>window.location.href = "login.php";</script>';
}
include '../db/db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $id = $_GET['id'];
  $newPassword = $_POST["new-password"];
  $confirmPassword = $_POST["confirm-password"];

  // Validate the passwords
  if ($newPassword !== $confirmPassword) {
    echo '<script>alert("Passwords do not match.");</script>';
    exit;
  }

  $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
  $sql = "SELECT * from user WHERE id = '$id'";
  $qry = $db->query($sql);
  $row = $qry->fetch_assoc();
  $currentHashedPassword = $row['password'];

  if (password_verify($newPassword, $currentHashedPassword)) {
    echo '<script>alert("New password cannot be the same as the current password.");</script>';
  } else {

    // Update the password
    $updateQuery = "UPDATE user SET password='$hashedPassword' WHERE id=$id";
    if ($db->query($updateQuery) === TRUE) {
      echo '<script>alert("Password changed successfully.");</script>';
      echo '<script>window.location.href = "view_user.php?id=' . $id . '";</script>';
    } else {
      echo '<script>alert("Error updating password.");</script>';
    }
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Change Password</title>
  <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
</head>

<body class="bg-gray-200">
  <?php include 'header.php'; ?>
  <div class="container mx-auto py-10">
    <h1 class="text-4xl font-bold text-center mb-10">Change Password</h1>
    <form action="" method="post" class="max-w-md mx-auto bg-white p-5 rounded shadow">
      <div class="mb-5">
        <label for="new-password" class="block mb-2 text-sm font-medium text-gray-600">New Password</label>
        <input type="password" name="new-password" id="new-password" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
      </div>
      <div class="mb-5">
        <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-600">Confirm Password</label>
        <input type="password" name="confirm-password" id="confirm-password" class="w-full border border-gray-200 p-3 rounded outline-none focus:border-purple-500" required>
      </div>
      <button type="submit" class="w-full py-2 bg-purple-600 text-white font-bold rounded hover:bg-purple-700">Change Password</button>
    </form>
  </div>
  
</body>

</html>