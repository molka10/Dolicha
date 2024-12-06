<?php
include '../Controller/ReservationC.php';

$ReservationC = new ReservationC();

if (isset($_GET["id"])) {
    $ReservationC->deleteReservation($_GET["id"]);
}

header('Location: ../view/dashboardResr.php');
?>