<?php
include 'C:\xampp\htdocs\dolichafinalCopy\controllers\EventC.php';

$eventC = new EventC();

if (isset($_GET["id"])) {
    $eventC->deleteEvent($_GET["id"]);
}

header('Location: ../back_office/dashboard.php');
?>
