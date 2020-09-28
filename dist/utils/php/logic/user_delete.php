<?php

/*
** -------------------------------------------------------------------------------------
** user_delete.php
** cody by: Domen Stropnik
** purpose: this file when called will delete the selected user from the system.
** -------------------------------------------------------------------------------------
**/

include_once "../session/session.php";
include_once "../session/database.php";

$id_user = $_SESSION['id_user'];
echo 'id is: '.$id_user;

if (!empty($id_user))
{
    $query = "SELECT * FROM users WHERE id_user = ?";
    $stmt_check = $pdo->prepare($query);
    $stmt_check->execute([$id_user]);

    if ($stmt_check->rowCount() > 0) // if the row exists it will be deleted
    {
        $sql_delete = "DELETE FROM attending_event WHERE id_user = ?";
        $pdo->prepare($sql_delete)->execute([$id_user]);

        $sql_delete = "DELETE FROM created_event WHERE id_user = ?";
        $pdo->prepare($sql_delete)->execute([$id_user]);

        $sql_delete = "DELETE FROM profile_photos WHERE id_user = ?";
        $pdo->prepare($sql_delete)->execute([$id_user]);

        $sql_delete = "DELETE FROM users WHERE id_user = ?";
        $pdo->prepare($sql_delete)->execute([$id_user]);

        $_SESSION['alert'] = "Your account was deleted";
        header("Location: logout.php");
        die();
    }
}

$_SESSION['alert'] = "Something went wrong!";
header("Location: ../../../profile.php");
die();
?>