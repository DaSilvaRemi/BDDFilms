<?php
function choix($a = 0)
{
    if ($a == 1) { //Sur btsio.org
        $db_username = 'sriruangp';
        $db_password = 'DyhYWVGou31H';
        $db_name     = 'sriruangp';
        $db_host     = 'localhost';
    } else { //Sur machine perso
        $db_username = 'phpmyadmin';
        $db_password = 'test';
        $db_name     = 'Films';
        $db_host     = 'localhost';
    }
    return array($db_host,$db_name,$db_username,$db_password);
}
