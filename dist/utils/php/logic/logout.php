<?php

/*
** -------------------------------------------------------------------------------------
** logout.php
** cody by: Domen Stropnik
** purpose: it just logs you out lol.
** -------------------------------------------------------------------------------------
**/

session_start();

session_destroy();

header("Location: ../../../login.php");
?>