<?php
class Product {
    private $id;
    private $name;
    private $price;
    private $stock;
    private $idCategory;

    public function __construct($id, $name, $price, $stock, $idCategory) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->idCategory = $idCategory;
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

    public function getIdCategory() {
        return $this->idCategory;
    }
}
?>