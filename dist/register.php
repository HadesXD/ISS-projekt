<?php 
    include_once 'utils/php/session/database.php';
    include_once 'utils/php/session/session.php';
    include_once 'alert.php';
 ?>

<!-- REGISTER -->
<!-- data is sent to the user_insert.php file -->

<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Planner</title>
    <link rel="stylesheet" href="utils/css/log_reg.css">
  </head>
  <body>
    <form class="box" action="utils/php/logic/user_insert.php" method="post">
      <h1>Register</h1>
      <input type="text" name="first_name" required="required" placeholder="First name"/>
      <input type="text" name="last_name" required="required" placeholder="Last name"/>
      <input type="text" name="email" required="required" placeholder="Email"/>
      <input type="password" name="pass1" required="required" placeholder="Password" id="pass1"/>
      <label class="container">Show Password
        <input type="checkbox" onclick="showPass()" name="checkbox" value="true">
        <span class="checkmark"></span>
      </label>
      <input type="password" name="pass2" required="required" placeholder="Confirm Password" id="pass2"/>
      <input type="submit" name="register" value="Register"/>
      <div>Already have an account?</div>
      <a href="login.php">Login!</a>
    </form>

    <script>
      function showPass() {
        let pass1 = document.getElementById("pass1");
        let pass2 = document.getElementById("pass2");

        if (pass1.type === "password" && pass2.type === "password") {
          pass1.type = "text";
          pass2.type = "text";
        } 
        else {
          pass1.type = "password";
          pass2.type = "password";
        }
      } 
    </script>
  </body>
</html>
