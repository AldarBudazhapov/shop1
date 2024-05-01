<?php

require_once './../Model/Product.php';
class ProductController
{
    public function getAll()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../view/login.php');
        }
        $productModel = new Product();
        $result = $productModel->getAll();

     require_once './../View/main.php';
    }
}