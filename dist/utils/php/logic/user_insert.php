<?php

/*
** -------------------------------------------------------------------------------------
** user_insert.php
** cody by: Domen Stropnik
** purpose: this file when called will add a new user to the database.
** -------------------------------------------------------------------------------------
**/

include_once '../session/session.php';
include_once '../session/database.php';

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];

if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($pass1) && ($pass1==$pass2)) 
{
    $query = "SELECT email FROM users WHERE email = ?";
    $stmt_check = $pdo->prepare($query);
    $stmt_check->execute([$email]);

    if($stmt_check->rowCount() > 0){
        $_SESSION['alert'] = "This users email is already in use! Please pick a different email.";
        header("Location: ../../../register.php");
        die();
    }
    else{   
        $pass = password_hash($pass1, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (first_name, last_name, email, pass, rank) VALUES (?,?,?,?,?)";
        $pdo->prepare($sql)->execute([$first_name,$last_name,$email,$pass,0]);

        $_SESSION['alert'] = "Successfully registered!";
        header("Location: ../../../login.php");
        die();
    }
}

$_SESSION['alert'] = "The data is incorrect.";
header("Location: ../../../register.php");
die();
?>

