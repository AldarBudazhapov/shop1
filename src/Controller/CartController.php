<?php

require_once './../Model/UserProduct.php';


class CartController
{
    public function getAddProduct()
         {
             require_once './../View/add-product.php';
         }

         public function addProduct()
         {
             session_start();
           if (!isset($_SESSION['user_id'])) {
               header('Location: /login');
           }
           $userId = $_SESSION['user_id'];
             if (isset($_POST['product-id'])) {
                 $productId = $_POST['product-id'];
             }

           $userProductModel = new UserProduct();
             $result = $userProductModel->getByUserIdAndProductId($userId, $productId);
           if ($result === null) {
               $userProductModel->create($userId, $productId);
           } else {
               $userProductModel->updateQuantity($userId, $productId, $result['quantity'] + 1);

           }


           header('Location: /main');
         }

         public function getUserCart()
         {
             session_start();
             if (!isset($_SESSION['user_id'])) {
                 header('Location: /login');
             }
             $userId = $_SESSION['user_id'];
             if (isset($_POST['product-id'])) {
                 $productId = $_POST['product-id'];
             }

             $userProducts = new UserProduct();
             $product = new Product();
             $userProducts = $userProducts->getUserId($userId);

             $productIds = [];
             foreach ($userProducts as $userProduct) {
                 $productIds[] = $userProduct['product_id'];
             }
             $products = [];
             foreach ($productIds as $productId) {
                $products[] = $product->getProductId($productId);
             }

             foreach ($products as &$product) {
                 foreach ($userProducts as $userProduct) {
                     if ($product['id'] === $userProduct['product_id']) {
                         $product['quantity'] = $userProduct['quantity'];
                     }
                 }

             }
             unset($product);
             require_once './../View/cart.php';


         }



}