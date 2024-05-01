<?php

class  Product
{
    public function getAll():array
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
        $stmt = $pdo->query('SELECT * FROM products ');
        $result = $stmt ->fetchAll();

        return $result;
    }

    public function getProductId($productId)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $productId]);

        $result = $stmt->fetch();

        return $result;

    }


}