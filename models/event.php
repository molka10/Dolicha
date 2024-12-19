<?php

class Event
{
    private ?int $id = null;
    private ?string $nom = null;
    private ?string $duration=null;
    private ?string $date = null;
    private ?string $lieu = null;
    private ?string $description = null;
    private ?string $prix = null;
    private ?string $image = null;

    public function __construct(
        $id,
        $nom,
        $duration,
        $date,
        $lieu,
        $description,
        $prix,
        $image
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->duration = $duration;
        $this->date = $date;
        $this->lieu = $lieu;
        $this->description = $description;
        $this->prix = $prix;
        $this->image = $image;
    }

    // Getters and setters
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }
    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getLieu()
    {
        return $this->lieu;
    }

    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }

  
    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }
    
}

?>
