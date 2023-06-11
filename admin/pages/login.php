<?php
// Connect to MySQL database using mysqli
session_start();
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
      echo '<script>alert("Login successful");</script>';
      echo '<script>window.location.href = "manage.php?category_id=1";</script>';
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
  <link rel="stylesheet" href="../assets/css/login.css" />
  <style>
    #password {
      border-radius: 8px;
    }
  </style>
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="56">
  <header class="masthead" style="
        background: url('../assets/imgs/bg-pattern.png'),
          linear-gradient(to left, #7b4397, #dc2430);
      ">
    <section class="login-clean" style="background-color: transparent; font-family: Poppins, sans-serif">
      <form action="" method="post" style="margin-top: 40px; background: rgb(195, 191, 191)" action="" id="login-form">
        <h2 class="visually-hidden">Login Form</h2>
        <div class="admin-logo">
          <img src="../assets/imgs/admin-logo.png" alt="Admin Logo" width="150" height="150" />
        </div>
        <div class="form-group mb-3">
          <input class="form-control" type="text" name="username" id="username" placeholder="Username" />
        </div>
        <div class="form-group mb-3">
          <input class="form-control" type="password" name="password" id="password" placeholder="Password" />
        </div>
        <div class="form-group mb-3">
          <button class="btn btn-primary d-block w-100" type="submit" style="background-color: #00b5a8">
            Login
          </button>
        </div>
        <a class="forgot" href="forget.php">ลืมรหัสผ่าน? <strong><span style="text-decoration: underline">คลิกที่นี่</span></strong></a>
      </form>
    </section>
  </header>
  <footer>
    <div class="container">
      <p>Copyright ©2023 -Computer Science #40</p>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="/assets/js/script.min.js"></script>

</body>

</html>