<?php 

class Product {
    public function __construct(
        private ?int $id,
        private $type,
        private $name,
        private $description,
        private $price,
        private $image = 'logo-serenatto.png'
    ) {}


    public function setImage(string $image){
        $this->image = $image;

    }
    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }
    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        $price = (float)$this->price;
        return $price;
    }

    public function getFormattedPrice() {
        $price = (float)$this->price;
        return "R$" . number_format($price, 2);
    }
    public function getImage() {
        return $this->image;
    }

    public function getImageDirectory() {
        return "img/" . $this->image;
    }

}