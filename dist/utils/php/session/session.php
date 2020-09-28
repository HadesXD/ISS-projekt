<?php
    session_start();
    
    if (!isset($_SESSION['id_user'])  && 
       (strpos ($_SERVER['REQUEST_URI'], 'register.php') == false)  &&
       (strpos ($_SERVER['REQUEST_URI'], 'login.php') == false)
    ){
        header("Location: login.php");
    }
?>
