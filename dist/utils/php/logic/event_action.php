<?php

/*
** -------------------------------------------------------------------------------------
** event_action.php
** cody by: Domen Stropnik
** purpose: this file when called will either insert new data or update existing data.
** -------------------------------------------------------------------------------------
**/

include_once "../session/session.php";
include_once "../session/database.php";

$id_event = $_POST['id_event'];
$event_name = $_POST['event_name'];
$event_type = $_POST['event_type'];
$limit_cap = $_POST['limit_cap'];
$action = $_POST['action'];

if (!empty($event_name) && !empty($event_type) && !empty($limit_cap) && is_numeric($limit_cap))
{
    $query = "SELECT event_name FROM events WHERE event_name = ? AND NOT id_event = ?";
    $stmt_check = $pdo->prepare($query);
    $stmt_check->execute([$event_name, $id_event]);

    if($stmt_check->rowCount() > 0)
    {
        $_SESSION['alert'] = "The event's name is already in use! Please pick a different name.";
        header("Location: ../../../index.php");
        die();
    }
    else 
    {
        if ($action === "insert")   // adding a new event
        {
            // adding data to the events entity
            $sql_insert = "INSERT INTO events (event_name, event_type, limit_attending, limit_cap) VALUES (?,?,?,?)";
            $pdo->prepare($sql_insert)->execute([$event_name, $event_type, 0, $limit_cap]);

            // adding data to the created_event entity
            $query = "SELECT id_event FROM events WHERE event_name = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$event_name]);

            $id_user = $_SESSION['id_user'];
            $id_event = $stmt->fetch();

            $sql_insert = "INSERT INTO created_event (id_user, id_event) VALUES (?,?)";
            $pdo->prepare($sql_insert)->execute([$id_user, $id_event[0]]);

            $_SESSION['alert'] = "The event was successfully added!";
        }
        else if ($action === "update")  // editing an existing event
        {
            $sql_update = "UPDATE events SET event_name = ?, event_type = ?, limit_cap = ? WHERE id_event =?";
            $pdo->prepare($sql_update)->execute([$event_name, $event_type, $limit_cap, $id_event]);

            $_SESSION['alert'] = "The event was successfully updated!";
        }
    } 
} else $_SESSION['alert'] = "The data was incorrect.";

header("Location: ../../../index.php");
die();
?>