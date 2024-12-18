<?php
class Product {
    private $id;
    private $name;
    private $price;
    private $stock;
    private $idCategory;
    private $image; 

    public function __construct($id, $name, $price, $stock, $idCategory, $image) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->idCategory = $idCategory;
        $this->image = $image; 
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
        return $this->image; 
    }

    public function getIdCategory() {
        return $this->idCategory;
    }
}
?>
