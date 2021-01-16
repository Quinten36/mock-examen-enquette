<?php
session_start();

if (!isset($_SESSION['username']) || strlen($_SESSION['username']) == 0) {
    //checken of de sessie bestaat en of de sessie niet leeg is
    header("Location: login.php");
    exit();
}