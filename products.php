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
    <link rel="stylesheet" href="./css/products.css"/>
</head>
<body>
<h1 class="product-title">Our Products</h1>
<div class="card-container">

        <?php foreach ($products as $product) : ?>
 <div class="card">
      <img src='<?php echo $product->getProductImage(); ?>' alt="" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title"><?php echo $product->getProductName(); ?></h5>
        <div class="card-text">
                        <p><span class="card-text-title">Quantity Available:</span> <?php echo $product->getQuantityAvailable(); ?></p>
                        <p><span class="card-text-title">Price: </span>$<?php echo $product->getPrice(); ?></p>
        </div>
       <a href="" class="btn btn-outline-success btn-sm">View Product Details</a>
      </div>
     </div>
        <?php endforeach; ?>
    </div>

</body>
</html>