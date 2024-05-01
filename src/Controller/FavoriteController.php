<?php
require_once './../Model/FavoriteProduct.php';
class FavoriteController
{
    public function getAddFavorite()
    {
        require_once './../View/add-favorite.php';
    }

    public function addFavorite()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        if (isset($_POST['product-id'])) {
            $productId = $_POST['product-id'];
        }

        $userFavoriteModel = new FavoriteProduct();
        $result = $userFavoriteModel->getByUserIdAndProductId($userId, $productId);
        if ($result === null) {
            $userFavoriteModel->create($userId, $productId);
        }
//


        header('Location: /main');
    }

    public function getUserFavorite()
    {    session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $userId = $_SESSION['user_id'];
        $pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
        $stmt = $pdo->prepare("SELECT * FROM  favorite_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

        $userProducts = [];
        $userProducts = $stmt->fetchAll();

        $productIds = [];

        foreach ($userProducts as $userProduct) {
            $productIds[] = $userProduct['product_id'];
        }
        $products = [];
        foreach ($productIds as $productId) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute(['id' => $productId]);

            $product = $stmt->fetch();
            $products[] = $product;
        }

//        foreach ($products as &$product) {
//            foreach ($userProducts as $userProduct) {
//                if ($product['id'] === $userProduct['product_id']) {
//                    $product['quantity'] = $userProduct['quantity'];
//                }
//            }
//        }
        require_once './../View/favorite.php';

    }
}