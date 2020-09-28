<?php
include_once "../session/session.php";
include_once "../session/database.php";

/*
** -------------------------------------------------------------------------------------
** event_attend.php
** cody by: Domen Stropnik
** purpose: this file when called will add or remove the user for the event attendance.
** -------------------------------------------------------------------------------------
**/

$id_user = $_POST['id_user'];
$id_event = $_POST['id_event'];

$query1 = "SELECT * FROM events WHERE id_event = ?";
$stmt_size = $pdo->prepare($query1);
$stmt_size->execute([$id_event]);
$values = $stmt_size->fetch();

$size = $values['limit_attending'];
$cap_num = $values['limit_cap'];

$query2 = "SELECT * FROM attending_event WHERE id_user = ? AND id_event = ?";
$stmt_check = $pdo->prepare($query2);
$stmt_check->execute([$id_user, $id_event]);

if ($stmt_check->rowCount() > 0) // removes the user
{
    $sql_delte = "DELETE FROM attending_event WHERE id_user = ? AND id_event = ?";
    $pdo->prepare($sql_delte)->execute([$id_user, $id_event]);

    $sql_update = "UPDATE events SET limit_attending = ? WHERE id_event = ?";
    $stmt = $pdo->prepare($sql_update);
    $stmt->execute([--$size, $id_event]);
}
else if ($size != $cap_num)
{
    $sql_insert = "INSERT INTO attending_event (id_user, id_event) VALUES (?,?)";
    $pdo->prepare($sql_insert)->execute([$id_user, $id_event]);

    $sql_update = "UPDATE events SET limit_attending = ? WHERE id_event = ?";
    $stmt = $pdo->prepare($sql_update);
    $stmt->execute([++$size, $id_event]);
}

header("Location: ../../../index.php");
die();
?>