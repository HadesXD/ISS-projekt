<?php 
    include_once 'utils/php/session/database.php';
    include_once 'utils/php/session/session.php';
 ?>

<!-- LOGIN FORM -->
<!-- data is sent to the login_check.php file -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Planner</title>
    <link rel="stylesheet" href="utils/css/log_reg.css">
  </head>
  <body>
    <?php include_once 'alert.php';?>
    <form class="box" action="utils/php/logic/login_check.php" method="POST">        
      <h1>Login</h1>
      <input type="text" name="email" placeholder="Email"/>
      <input type="password" name="pass" placeholder="Password" id="pass"/>
      <label class="container">Show Password
        <input type="checkbox" onclick="showPass()" name="checkbox" value="true">
        <span class="checkmark"></span>
      </label>
      <input type="submit" name="login" value="Login"/>
      <div>Don't have an account?</div>
        <a href="register.php">Register now!</a>
    </form>

    <script>
      function showPass() {
        let pass = document.getElementById("pass");

        if (pass.type === "password") {
          pass.type = "text";
        } 
        else {
          pass.type = "password";0
        }
      } 
    </script>
  </body>
</html>
