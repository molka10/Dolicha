<?php
include '../config.php'; // Inclure le fichier config.php
include '../Model/Event.php'; // Inclure le fichier Hotel.php

class EventC
{
    public function listEvents()
    {
        $sql = "SELECT * FROM events";
        $db = Config::getConnexion();
        try {
            $stmt = $db->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function deleteEvent($id)
    {
        $sql = "DELETE FROM events WHERE id = :id";
        $db = Config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function ajouterEvent($event)
    {
        $sql = "INSERT INTO events VALUES (NULL, :nom, :duration ,:date, :lieu, :description, :prix,:image)";
        $db = Config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $event->getNom(),
                'duration' =>$event->getDuration(),
                'date' => $event->getDate(),
                'lieu' => $event->getLieu(),
                'description' => $event->getDescription(),
                'prix' => $event->getPrix(),
                'image' => $event->getImage()
            ]);
            echo "Event ajouté avec succès.";
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    public function updateEvent($id, $nom, $duration, $date, $lieu, $description, $prix, $image)
{
    $db = config::getConnexion();

    try {
        if (!empty($image)) {
            // Query to update all fields including a new image
            $sql = "UPDATE events 
                    SET nom = :nom,
                        duration = :duration,
                        date = :date,
                        lieu = :lieu,
                        description = :description,
                        prix = :prix,
                        image = :image
                    WHERE id = :id";
        } else {
            // Query to update all fields except image
            $sql = "UPDATE events 
                    SET nom = :nom,
                        duration = :duration,
                        date = :date,
                        lieu = :lieu,
                        description = :description,
                        prix = :prix
                    WHERE id = :id";
        }

        $query = $db->prepare($sql);

        // Bind common parameters
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':duration', $duration);
        $query->bindParam(':date', $date);
        $query->bindParam(':lieu', $lieu);
        $query->bindParam(':description', $description);
        $query->bindParam(':prix', $prix);

        // Bind image parameter if a new image is provided
        if (!empty($image)) {
            $query->bindParam(':image', $image);
        }

        // Execute the query
        $query->execute();

        // Return a success message or row count
        return $query->rowCount() . " record(s) updated successfully.";
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

    public function getEventById($id)
    {
        $sql = "SELECT * FROM events WHERE id = :id";
        $db = config::getConnexion();
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }


}
?>
