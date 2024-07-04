<?php

class ProductRepository
{


    public function __construct(
        private PDO $pdo
    ){}


    public function formatObject(array $data): Product
    {
        return new Product($data['id'], 
            $data['tipo'],
            $data['nome'],
            $data['descricao'], 
            $data['preco'],
            $data['imagem'],
        );
    }
    public function coffeeOptions(): array
    {
        $sql1 = "SELECT * FROM produtos WHERE tipo = 'cafe' ORDER BY preco";
        $statement = $this->pdo->query($sql1);
        $coffeeProducts = $statement->fetchAll(PDO::FETCH_ASSOC);

        $coffeData = array_map(function($coffee) {
            return $this->formatObject($coffee);
        }, $coffeeProducts);

        return $coffeData;
    }

    public function lunchOptions(): array
    {
        $sql2 = "SELECT * FROM produtos WHERE tipo = 'almoco' ORDER BY preco";
        $statement = $this->pdo->query($sql2);
        $lunchProducts = $statement->fetchAll(PDO::FETCH_ASSOC);

        $lunchData = array_map(function($lunch) {
            return $this->formatObject($lunch);
        }, $lunchProducts);

        return $lunchData;
    }

    public function allProducts(): array
    {
        $sql3 = "SELECT * FROM produtos ORDER BY preco";
        $statement = $this->pdo->query($sql3);
        $allProducts = $statement->fetchAll(PDO::FETCH_ASSOC);

        $allData = array_map(function($product) {
            return $this->formatObject($product);
        }, $allProducts);

        return $allData;
    }

    public function delete(int $id) 
    {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $statement = $this->pdo->prepare($sql) ;
        $statement->bindValue(1, $id);
        $statement->execute();

    }

    public function create(Product $product)
    {
        $sql = "INSERT INTO produtos (tipo, nome, descricao, imagem, preco) VALUES (?, ?, ?, ?, ?)";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $product->getType());
        $statement->bindValue(2, $product->getName());
        $statement->bindValue(3, $product->getDescription());
        $statement->bindValue(5, $product->getPrice());
        $statement->bindValue(4, $product->getImage());
        $statement->execute();
    }

    public function findProduct(int $id): Product
    {
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);
        $statement->execute();

        $product = $statement->fetch(PDO::FETCH_ASSOC);

        return $this->formatObject($product);

    }

    public function update(Product $product)
    {
        $sql = "UPDATE produtos SET tipo = ?, nome = ?, descricao = ?, preco = ? WHERE id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $product->getType());
        $statement->bindValue(2, $product->getName());
        $statement->bindValue(3, $product->getDescription());
        $statement->bindValue(4,$product->getPrice());
        $statement->bindValue(5, $product->getId());
        $statement->execute();

        if($product->getImage() !== 'logo-serenatto.png'){
            
            $this->updatePhoto($product);
        }
    }

    private function updatePhoto(Product $product)
    {
        $sql = "UPDATE produtos SET imagem = ? WHERE id = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $product->getImage());
        $statement->bindValue(2, $product->getId());
        $statement->execute();
    }
}