<?php
require_once "dal/dbhelper.php";
require_once "dal/product.php";

// Create an instance of the Product class
$product = new Product();

// Call the fetchProducts() method to retrieve the products
$products = $product->fetchProducts();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

        <tbody>
            <?php foreach ($products as $product) : ?>
                <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product->getProductName(); ?></h5>
                    <p class="card-text">
                    <p><?php echo $product->getQuantityAvailable(); ?></p>
                    <p><?php echo $product->getPrice(); ?></p>
                    </p>
                    <a href="#" >Go somewhere</a>
                </div>
           
     
            <?php endforeach; ?>
        </tbody>

</body>
</html>