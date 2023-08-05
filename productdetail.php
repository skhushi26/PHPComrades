<?php 
  require_once "./dal/dbhelper.php";
  $dbHelper = new DBHelper();
  session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Details - Home Decor</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="./css/site.css">
  <link rel="stylesheet" href="./css/productdetail.css">
</head>

<body>

  <!-- NAVIGATION  -->
  <?php require_once "navigation.php"; ?> 

  <div class="container">
    <div class="product">
      <div class="product-images">
        <div id="productCarousel" class="carousel slide">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="images\product-1.jpg" class="d-block w-100" alt="Product Image 1">
            </div>
            <div class="carousel-item">
              <img src="images\Buddha Statue 2.jpg" class="d-block w-100" alt="Product Image 2">
            </div>
            <div class="carousel-item">
              <img src="images\Buddha Statue 3.jpg" class="d-block w-100" alt="Product Image 3">
            </div>
            <div class="carousel-item">
              <img src="images\Buddha Statue 45.jpg" class="d-block w-100" alt="Product Image 4">
            </div>

          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

        <!-- Thumbnail pictures -->
        <div class="thumbnail-gallery mt-2">
          <img src="images\Buddha Statue.jpg" class="thumbnail-image" alt="Thumbnail Image 1" onclick="updateMainImage(0)">
          <img src="images\Buddha Statue 2.jpg" class="thumbnail-image" alt="Thumbnail Image 2" onclick="updateMainImage(1)">
          <img src="images\Buddha Statue 3.jpg" class="thumbnail-image" alt="Thumbnail Image 3" onclick="updateMainImage(2)">
          <img src="images\Buddha Statue 45.jpg" class="thumbnail-image" alt="Thumbnail Image 4" onclick="updateMainImage(3)">
        </div>
      </div>
      <div class="product-details">
        <div class="product-name">Buddha Statue</div>
        <div class="product-price">$99.99</div>

        <!-- Stars of rating -->
        <div class="star-rating">
          <span class="rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </span>
          <span class="rating-text">(5.0)</span>
        </div>

        <!-- Quantity of product-->
        <div class="product-options">
          <div class="option-label">Quantity:</div>
          <select class="form-control ddlQuantity" name="qty_<?php echo $index; ?>" >
            <?php
                // $productId = $row["ProductId"];
                for ($quantity = 1; $quantity <= 10; $quantity++) {
                    // $selected = $_SESSION["qty_array"][$productId] == $quantity ? "selected" : "";
                    echo "<option value='$quantity' $selected>$quantity</option>";
                }
            ?>
          </select>
         </div>

        <button class="btn btn-danger">Add to Cart</button>

        <div class="product-description"> </br>
          <b>About Product</b> <br>
          This Buddha statue is 5.6 x 4.7 x 9 inches (long*wide*high), it is made of durable resin material This unique
          wood-like grain texture, some painted details in gold and cyan make the whole look more natural, with smooth
          lines and very rustic. It imparts an atmosphere of calm and contemplation everywhere, bringing a positive
          impact to everyday life.
        </div>
      </div>
    </div>
  </div>

</body>

<!-- script to initialize the carousel -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
  // Initializing the carousel
  const productCarousel = new bootstrap.Carousel(document.getElementById('productCarousel'));

  // Function to update the main product image when clicked
  function updateMainImage(thumbnailIndex) {

    // Jump to the selected slide (thumbnail)
    productCarousel.to(thumbnailIndex);
  }
</script>
</body>

</html>