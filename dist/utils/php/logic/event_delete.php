<?php

/*
** -------------------------------------------------------------------------------------
** event_delete.php
** cody by: Domen Stropnik
** purpose: this file when called will delete the selected event from the database.
** -------------------------------------------------------------------------------------
**/

include_once "../session/session.php";
include_once "../session/database.php";

$id_event = $_POST['id_event'];

if (!empty($id_event))
{
    $query = "SELECT * FROM events WHERE id_event = ?";
    $stmt_check = $pdo->prepare($query);
    $stmt_check->execute([$id_event]);

    if ($stmt_check->rowCount() > 0) // if the row exists it will be deleted
    {
        $sql_delete = "DELETE FROM attending_event WHERE id_event = ?";
        $pdo->prepare($sql_delete)->execute([$id_event]);

        $sql_delete = "DELETE FROM created_event WHERE id_event = ?";
        $pdo->prepare($sql_delete)->execute([$id_event]);

        $sql_delete = "DELETE FROM events WHERE id_event = ?";
        $pdo->prepare($sql_delete)->execute([$id_event]);
    }
    else {
        $_SESSION['alert'] = "The event does not exist";
        header("Location: ../../../index.php");
        die();
    }
}

$_SESSION['alert'] = "The event was deleted!";
header("Location: ../../../index.php");
die();
?>