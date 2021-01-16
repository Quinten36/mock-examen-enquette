<?php
## database logingegevens ##
$db_hostname = 'localhost';
$db_username = '83502';
$db_password = 'xS33&j3hYajj06*99vud^0M6';
//--> Bijv. :: https://passwordsgenerator.net/
$db_database = '83502_DB';

## maak de database-verbinding ##
$mysqli = new mysqli($db_hostname, $db_username, $db_password, $db_database);

## controleer connectie ##
if ($mysqli -> connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

##  Nu zorg ik ervoor dat de bovenstaande user/pass niet later op de pagina ##
##  waar deze ge-included wordt, uitgelezen kan worden. ##
unset($db_username, $db_password);
?>