<?php

// Include database connection
include '../db/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Retrieve form data
	$email = $_POST['email'];
	$password = $_POST['newPassword'];
	$confirm_password = $_POST['confirmPassword'];

	// Validate form data
	if (empty($email) || empty($password) || empty($confirm_password)) {
		$_SESSION['error'] = 'All fields are required';
		header('Location: forget_password.html');
		exit();
	} elseif ($password != $confirm_password) {
		$_SESSION['error'] = 'Passwords do not match';
		header('Location: forget_password.html');
		exit();
	} else {
		// Check if the email exists in the database
		$stmt = $db->prepare('SELECT * FROM user WHERE email = ?');
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows == 0) {
			$_SESSION['error'] = 'Email not found';
			header('Location: forget_password.html');
			exit();
		} else {
			// Update the password in the database
			$stmt = $db->prepare('UPDATE user SET password = ? WHERE email = ?');
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			$stmt->bind_param('ss', $hashed_password, $email);
			$stmt->execute();
			$_SESSION['success'] = 'Password updated successfully';
			header('Location: login.php');
			exit();
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
        <div class="flex flex-col space-y-2">
          <label class="text-gray-700 font-bold" for="newPassword">New Password</label>
          <input class="border rounded-lg py-2 px-3" type="password" id="newPassword" name="newPassword" required />
        </div>
        <div class="flex flex-col space-y-2">
          <label class="text-gray-700 font-bold" for="confirmPassword">Confirm Password</label>
          <input class="border rounded-lg py-2 px-3" type="password" id="confirmPassword" name="confirmPassword" required />
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