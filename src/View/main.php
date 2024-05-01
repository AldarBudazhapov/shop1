<?php

if (!isset($_SESSION ['user_id'])){
    header('Location: /login');
}
$pdo = new PDO("pgsql:host=db; port=5432; dbname=testdb", 'testuser', 'testpwd');
$stmt = $pdo->query('SELECT * FROM products ');
$result = $stmt ->fetchAll();

//print_r($result);
?>

<div class="container">
    <h3>Catalog</h3>
    <a href="/logout">ВЫЙТИ</a>
    <a href="/cart">CART</a>
    <a href="/favorite">FAVORITE</a>
    <div class="card-deck">
        <?php foreach ($result as $product): ?>
        <form action="/add-product" method="POST">
            <div class="card text-center">
                <a href="#">
                    <div class="card-header">
                        <?php echo $product['name'];?>
                    </div>
                    <img class="card-img-top" src="<?php echo $product['image'];?>" alt="Card image">
                    <div class="card-body">
                        <p class="card-text text-muted"><?php echo $product['charact'];?></p>
                        <a href="#"><h5 class="card-title">ЦЕНА</h5></a>
                        <div class="card-footer">
                            <?php echo $product['price'], ' РУБЛЕЙ';?>
                        </div>
                    </div>
                </a>
            </div>
            <input type="text" hidden placeholder="Enter product-id" name="product-id" id="product-id" value=" <?php  echo $product['id'] ?>"required>
            <button type="submit">Add</button>
        </form>
            <form action="/add-favorite" method="POST">
                <input type="text" hidden placeholder="Enter product-id" name="product-id" id="product-id" value=" <?php  echo $product['id'] ?>"required>
                <button type="submit">ADD Favorite</button>
            </form>
        <?php endforeach;?>
    </div>
</div>
<style>
    body {
        font-style: sans-serif;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 13px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 11px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>
