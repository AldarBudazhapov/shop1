<?php

class UserProduct
{
    public function create(int $userId, int $productId, int $quantity = 1)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getByUserIdAndProductId(int $userId, int $productId): ?array
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $result = $stmt->fetch();

        if ($result === false) {
            return null;
        }

        return $result;
    }

    public function updateQuantity(int $userId, int $productId, int $quantity)
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
        $stmt = $pdo->prepare("UPDATE user_products SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['quantity' => $quantity, 'user_id' => $userId, 'product_id' => $productId]);
    }

    public function getUserId(int $userId)
    {
        $userId = $_SESSION['user_id'];
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
        $stmt = $pdo->prepare("SELECT * FROM  user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

        $userProducts = [];
        $userProducts = $stmt->fetchAll();

        return $userProducts;
    }


}