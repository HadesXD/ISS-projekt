<?php

/*
** -------------------------------------------------------------------------------------
** service.php
** cody by: Domen Stropnik
** purpose: gets the data from the MySQL database and then encodes it so JavaScript can use it.
** -------------------------------------------------------------------------------------
**/

include_once '../session/session.php';
include_once '../session/database.php';

$data = array();
// we get the data from the event
$stmt_events = $pdo->query('SELECT * FROM EVENTS');

while ($row = $stmt_events->fetch()) {
    // we get the data on who made the event
    $stmt_creator = $pdo->query('SELECT * FROM USERS u INNER JOIN CREATED_EVENT eu USING(id_user)
                            WHERE eu.id_event = '.$row['id_event'].'');
    $user = $stmt_creator->fetch();
    $row[] = $user['first_name'].' '.$user['last_name']; // we wanna get the maker!

    // we get the data on wether the user is attending the vent or not
    $query = "SELECT * FROM attending_event WHERE id_user = ? AND id_event = ?";
    $stmt_attendance = $pdo->prepare($query);
    $stmt_attendance->execute([$_SESSION['id_user'], $row['id_event']]);

    $row[] = ($stmt_attendance->rowCount() > 0) ? true : false;

    $data[] = $row;
}

echo json_encode($data);
?>