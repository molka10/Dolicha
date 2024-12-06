<?php

class Reservation
{
    private ?int $id = null;
    private ?int $eventId = null;
    private ?string $name = null;
    private ?string $email = null;

    public function __construct(
        $id = null,
        $eventId = null,
        $name = null,
        $email = null,
    ) {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->name = $name;
        $this->email = $email;
    }

    // Getters and setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function geteventId(): ?int
    {
        return $this->eventId;
    }

    public function setEventId(?int $eventId): self
    {
        $this->eventId = $eventId;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getReservationDate(): ?string
    {
        return $this->reservationDate;
    }

    public function setReservationDate(?string $reservationDate): self
    {
        $this->reservationDate = $reservationDate;
        return $this;
    }
}

?>
