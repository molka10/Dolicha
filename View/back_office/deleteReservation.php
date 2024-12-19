<?php
include 'C:\xampp\htdocs\dolichafinalCopy\controllersr\ReservationC.php';

$ReservationC = new ReservationC();

if (isset($_GET["id"])) {
    $ReservationC->deleteReservation($_GET["id"]);
}

header('Location: ../back_office/dashboardResr.php');
?>