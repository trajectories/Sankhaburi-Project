<?php

session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title></title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <link rel="stylesheet" href="assets/css/custom-login.css" />
  <style>
    #password {
      border-radius: 8px;
    }
  </style>
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="56">
  <header class="masthead" style="
        background: url('assets/img/bg-pattern.png'),
          linear-gradient(to left, #7b4397, #dc2430);
      ">
    <section class="login-clean" style="background-color: transparent; font-family: Poppins, sans-serif">
      <form method="post" style="margin-top: 40px; background: rgb(195, 191, 191)" action="" id="login-form">
        <h2 class="visually-hidden">Login Form</h2>
        <div class="illustration">
          <img src="assets/img/logo-login.png" width="200px" height="200px" class="img-fluid" />
        </div>
        <div class="form-group mb-3">
          <input class="form-control" type="email" name="email" id="email" placeholder="Email" />
        </div>
        <div class="form-group mb-3">
          <input class="form-control" type="password" name="password" id="password" placeholder="Password" />
        </div>
        <div class="form-group mb-3">
          <button class="btn btn-primary d-block w-100" type="submit" style="background-color: #00b5a8">
            Login
          </button>
        </div>
        <a class="forgot" href="register.php">ยังไม่ได้สมัครสมาชิก?
          <strong><span style="text-decoration: underline">คลิกที่นี่</span></strong></a><a class="forgot" href="pages/forget.php">ลืมรหัสผ่าน?
          <strong><span style="text-decoration: underline">คลิกที่นี่</span></strong></a>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/script.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#login-form").submit(function(e) {
        e.preventDefault();
        var email = $("#email").val();
        var password = $("#password").val();
        $.ajax({
          type: "POST",
          url: "services/login.php",
          data: {
            email: email,
            password: password
          },
          success: function(data) {
            if (data == "success") {
              window.location.replace("pages/home.php");
              Swal.fire({
                title: 'Login Success',
                icon: 'success',
              });
            } else {
              // Update the error message in the modal body
              $("#error-message").text("Invalid username or password.");
              // Display the error modal
              var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
              errorModal.show();
            }
          }
        });
      });
    });
  </script>