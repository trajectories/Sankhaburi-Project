<?php
// Include the database connection file
include '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the email entered in the form
  $email = $_POST['email'];

  // Check if the email exists in the database
  $query = "SELECT * FROM user WHERE email = '$email'";
  // Assuming 'users' is the table name where user information is stored
  // Adjust the query and table name according to your database structure

  // Execute the query and fetch the user data
  $result = mysqli_query($db, $query);

  if (mysqli_num_rows($result) > 0) {
    // Email exists in the database

    // Generate a hash of the default password
    $password = "111111"; // Default password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $updateQuery = "UPDATE user SET password = '$hashedPassword' WHERE email = '$email'";
    mysqli_query($db, $updateQuery);

    // Send the default password to the user's email
    $subject = "Your Password Reset";
    $message = "Your new password is: $password";
    // Adjust the email message according to your requirements

    // Assuming you have a function to send emails
    // Replace the placeholders with your actual email sending code
    mail($email, $subject, $message);
    echo '<script>alert("Password reset successfully. Please check your email.");</script>';
  } else {
    echo '<script>alert("Email does not exist.");</script>';
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Forget Password</title>
  <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
</head>

<body class="bg-gray-200">

  <div class="flex flex-col justify-center items-center min-h-screen">
    <div class="w-full sm:w-4/5 md:w-3/5 lg:w-2/5 xl:w-1/4 bg-white rounded-lg shadow-lg p-6">
      <h2 class="text-2xl text-center font-bold mb-4">ลืมรหัสผ่าน</h2>
      <form class="space-y-4" action="" method="POST">
        <div class="flex flex-col space-y-2">
          <label class="text-gray-700 font-bold" for="email">Email</label>
          <input class="border rounded-lg py-2 px-3" type="email" id="email" name="email" required />
        </div>
        <div class="flex justify-center">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Submit
          </button>
        </div>
      </form>
      <a href="login.php" class="flex justify-end text-decoration-underline mt-5 text-red-900">กลับไปยังหน้า login</a>
    </div>
  </div>
</body>

</html>