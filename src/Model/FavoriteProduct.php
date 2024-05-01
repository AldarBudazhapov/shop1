<?php

require_once './../DB.php';

class FavoriteProduct
{
    public function create(int $userId, int $productId)
    {
        $db = new DB;
        $pdo = $db->connect();

        $stmt = $pdo->prepare("INSERT INTO favorite_products (user_id, product_id) VALUES (:user_id, :product_id)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function getByUserIdAndProductId(int $userId, int $productId): ?array
    {
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
        $stmt = $pdo->prepare("SELECT * FROM favorite_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $result = $stmt->fetch();

        if ($result === false) {
            return null;
        }

        return $result;
    }

//    public function updateQuantity(int $userId, int $productId, int $quantity)
//    {
//        $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
//        $stmt = $pdo->prepare("UPDATE user_products SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
//        $stmt->execute(['quantity' => $quantity, 'user_id' => $userId, 'product_id' => $productId]);
//    }
}