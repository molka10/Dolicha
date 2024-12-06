<?php
include '../config.php'; // Inclure le fichier config.php
include '../Model/Reservation.php'; // Inclure le fichier Reservation.php

class ReservationC
{
    public function listReservations()
    {
        // Updated SQL query to join the reservations and events tables
        $sql = "
            SELECT 
                reservations.id, 
                reservations.eventId, 
                reservations.name, 
                reservations.email, 
                events.nom AS eventName 
            FROM 
                reservations
            JOIN 
                events 
            ON 
                reservations.eventId = events.id
        ";
    
        $db = Config::getConnexion();
    
        try {
            $stmt = $db->query($sql); // Execute the query
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch data as an associative array
            return $data; // Return the fetched data
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage()); // Handle exceptions
        }
    }
    
    public function addReservation($reservation) {
        $sql = "INSERT INTO reservations (name, email, eventId) VALUES (:name, :email, :eventId)";
        $db = Config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'name' => $reservation->getName(),
                'email' => $reservation->getEmail(),
                'eventId' => $reservation->geteventId(),
            ]);
            echo "Reservation added successfully.";
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    public function deleteReservation($id)
    {
        $sql = "DELETE FROM reservations WHERE id = :id";
        $db = Config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function getReservationById($id)
    {
        $sql = "SELECT * FROM reservations WHERE id = :id";
        $db = config::getConnexion();
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function updateReservation($id, $name, $email)
    {
        $sql = "UPDATE reservations
        SET name = :name,
            email = :email
        WHERE id = :id";
        
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id);
            $query->bindParam(':name', $name);
            $query->bindParam(':email', $email);
            $query->execute();
            echo "Reservation updated successfully.";
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function listReservationsByEventId($eventId)
    {
        $sql = "SELECT * FROM reservations WHERE eventId = :eventId";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':eventId', $eventId);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getTotalReservationsByEventId($eventId) {
    $sql = "SELECT COUNT(*) as count FROM reservations WHERE eventId = :eventId";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return 0;
    }
}
public function hasUserReserved($db, $userEmail, $eventId) {
    try {
        $sql = "SELECT COUNT(*) as count FROM reservations WHERE email = :email AND eventId = :eventId";
        $query = $db->prepare($sql);
        $query->bindParam(':email', $userEmail);
        $query->bindParam(':eventId', $eventId);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}
}
?>
