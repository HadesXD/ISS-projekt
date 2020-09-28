<?php
    //povezava na bazo
    $host = '127.0.0.1';
    $user = 'event_root';
    $db = 'event_db';
    $pass = 'domen123';
    $dsn = "mysql:host=$host; dbname=$db";

    try {
        $pdo = new PDO($dsn, $user, $pass);
    } 
    catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
?>

