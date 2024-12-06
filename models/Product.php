<?php
class Product {
    private $id;
    private $name;
    private $price;
    private $stock;
    private $idCategory;
    private $image; // Ensure this property is declared here

    public function __construct($id, $name, $price, $stock, $idCategory, $image) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->idCategory = $idCategory;
        $this->image = $image; // Assign the image parameter to the image property
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getImage() {
        return $this->image; // Ensure the method is defined correctly
    }

    public function getIdCategory() {
        return $this->idCategory;
    }
}
?>
