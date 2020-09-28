<?php

/*
** -------------------------------------------------------------------------------------
** user_update.php
** cody by: Domen Stropnik
** purpose: this file when called update the user's information.
** -------------------------------------------------------------------------------------
**/

include_once '../session/session.php';
include_once '../session/database.php';

$id_user = $_SESSION['id_user'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];

if (!empty($first_name) && !empty($last_name) && !empty($email)) 
{
    $query = "SELECT email FROM users WHERE email = ? AND NOT id_user = ?";
    $stmt_check = $pdo->prepare($query);
    $stmt_check->execute([$email, $id_user]);

    if($stmt_check->rowCount() > 0){
        $_SESSION['alert'] = "This users email is already in use! Please pick a different email.";
        header("Location: ../../../profile.php");
        die();
    }
    else{   
        $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id_user = ?";
        $pdo->prepare($sql)->execute([$first_name, $last_name, $email, $id_user]);

        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['full_name'] = $first_name.' '.$last_name;
        $_SESSION['email'] = $email;

        $_SESSION['alert'] = "Successfully updated!";
        header("Location: ../../../profile.php");
        die();
    }
}

$_SESSION['alert'] = "The data is incorrect.";
header("Location: ../../../update.php");
die();
?>

