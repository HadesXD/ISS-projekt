<?php

/*
** -------------------------------------------------------------------------------------
** login_check.php
** cody by: Domen Stropnik
** purpose: this file when called to check if the user's credentials are valid for a login.
** -------------------------------------------------------------------------------------
**/

include_once '../session/session.php';
include_once '../session/database.php';

$email = $_POST['email'];
$pass = $_POST['pass'];

if (!empty($email) && !empty($pass)) {
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() == 1) 
    {
        $user = $stmt->fetch();
        if (password_verify($pass, $user['pass'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['full_name'] = $user['first_name'].' '.$user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['rank'] = $user['rank'];

            $_SESSION['alert'] = "Congrats you logged in!";
            header("Location: ../../../index.php");
            die();
        }
    }
}

$_SESSION['alert'] = "The data is incorrect.";
header("Location: ../../../login.php");
die();
?>