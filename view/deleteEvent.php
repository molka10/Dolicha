<?php
include '../Controller/EventC.php';

$eventC = new EventC();

if (isset($_GET["id"])) {
    $eventC->deleteEvent($_GET["id"]);
}

header('Location: ../view/dashboard.php');
?>
