<?php

if (isset($_SESSION['alert']))
{
    $sporocila[] = $_SESSION['alert'];
    if( count($sporocila) > 0 ) 
    {   
        for($i = 0; $i < count($sporocila); $i ++) 
        {
            ?>
            <p class="alert">
                <?php if ($sporocila[$i] != []) echo json_encode($sporocila[$i]); ?>
            </p>     
            <?php
        }
        $_SESSION['alert'] = [];
    } 
}


        




