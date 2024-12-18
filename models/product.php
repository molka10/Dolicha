<?php
class Product {
    private $ID_Product;
    private $Name;
    private $Price;
    private $Stock;
    private $ID_Category;
    private $Image;

    public function __construct($ID_Product, $Name, $Price, $Stock, $ID_Category, $Image = null) {
        $this->ID_Product = $ID_Product;
        $this->Name = $Name;
        $this->Price = $Price;
        $this->Stock = $Stock;
        $this->ID_Category = $ID_Category;
        $this->Image = $Image;
    }

    public function getId() {
        return $this->ID_Product;
    }

    public function getName() {
        return $this->Name;
    }

    public function getPrice() {
        return $this->Price;
    }

    public function getStock() {
        return $this->Stock;
    }

    public function getCategoryId() {
        return $this->ID_Category;
    }

    public function getImage() {
        return $this->Image;
    }
}

?>
