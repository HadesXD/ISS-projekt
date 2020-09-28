<?php

/*
** -------------------------------------------------------------------------------------
** picture_insert.php
** cody by: Islam Mušič, Domen Stropnik
** purpose: when call it will update the existing profile picture or add a new one.
** -------------------------------------------------------------------------------------
**/

include_once '../session/session.php';
include_once '../session/database.php';

$user_id = $_SESSION['id_user'];
$target_dir = "../../../images/";
$path_name = "images/";
$change_name = "P-".date("Y-m-d-h-i-s")."-".$user_id."-";
$full_path_name = $path_name . $change_name . basename($_FILES["fileToUpload"]["name"]);

$target_file = $target_dir . $change_name . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $uploadOk = 0;
}

// Check if $uploadOk is set to 1 
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        
        $query = "SELECT * FROM profile_photos pp 
            INNER JOIN users u ON pp.id_user = u.id_user WHERE pp.id_user=?";
        //ORDER BY date_add ASC";

        $stmt=$pdo->prepare($query);
        $stmt->execute([$_SESSION['id_user']]);
        
        if ($stmt->rowCount() == 0) {       // inserting a profile picture
            $query = "INSERT INTO profile_photos (url, id_user) VALUES (?,?)";
            $stmt=$pdo->prepare($query);
            $stmt->execute([$full_path_name, $user_id]);
            $_SESSION['alert'] = "You successfully inserted a profile picture";
        }
        else {      // updating the profile picture
            $query = "UPDATE profile_photos SET url = ? WHERE id_user = ?";
            $stmt=$pdo->prepare($query);
            $stmt->execute([$full_path_name, $user_id]);
            $_SESSION['alert'] = "You successfully updated your profile picture";
        }
    } 
}

header("Location: ../../../profile.php");
die();
?>