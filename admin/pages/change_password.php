<?php
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
  <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css" />
</head>

<body class="bg-gray-200">
<?php include 'header.php'; ?>
  <div class="flex flex-col justify-center items-center min-h-screen">
    <div class="w-full sm:w-4/5 md:w-3/5 lg:w-2/5 xl:w-1/4 bg-white rounded-lg shadow-lg p-6">
      <h2 class="text-2xl text-center font-bold mb-4">Change Password</h2>
      <form class="space-y-4" action="" method="POST">
        <div class="flex flex-col space-y-2">
          <label class="text-gray-700 font-bold" for="new-password">New Password</label>
          <input class="border rounded-lg py-2 px-3" type="password" id="new-password" name="new-password" required />
        </div>
        <div class="flex flex-col space-y-2">
          <label class="text-gray-700 font-bold" for="confirm-password">Confirm Password</label>
          <input class="border rounded-lg py-2 px-3" type="password" id="confirm-password" name="confirm-password" required />
        </div>
        <div class="flex justify-center">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Change Password
          </button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>