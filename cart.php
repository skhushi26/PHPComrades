<?php
require_once "./dal/dbhelper.php";
$dbHelper = new DBHelper();
session_start();

if (!isset($_SESSION["cart"])) {
  $_SESSION["cart"] = [];
}

//  array_push($_SESSION['cart'], 1);
//  array_push($_SESSION['cart'], 2);
//  array_push($_SESSION['cart'], 3);
// unset($_SESSION["cart"]);

// echo var_dump($_SESSION["cart"]);

// Add to cart functionality
if (isset($_GET["id"])) {
  // Check if product is already in the cart
  if (!in_array($_GET["id"], $_SESSION["cart"])) {
    array_push($_SESSION["cart"], $_GET["id"]);
    $_SESSION["message"] = "Product added to cart";
  } else {
    $_SESSION["message"] = "Product already in cart";
  }
  header("location: index.php");
  exit();
}

// Clear cart functionality
if (isset($_GET["clear"])) {
  unset($_SESSION["cart"]);
  $_SESSION["message"] = "Cart cleared successfully";
  // header('location: index.php');
  // exit;
}

// Save cart changes functionality
if (isset($_POST["save"])) {
  foreach ($_POST["indexes"] as $key) {
    $_SESSION["qty_array"][$key] = $_POST["qty_" . $key];
  }
  $_SESSION["message"] = "Cart updated successfully";
}
?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <title>Shopping Cart</title>
      <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="./css/site.css">
      <link rel="stylesheet" href="./css/cart.css">
      <link rel="shortcut icon" href="./images/decor.png">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

      <script>
        $(document).ready(function() {
              $(".btn-save-for-later").click(function() {
          // Toggle the classes for the <i> element
          $(this).find("i").toggleClass("fa-heart-o fa-heart");
          $(this).toggleClass("btn-save-for-later-clicked");
        });


        // Function to calculate and update the total based on the shipping option
      function updateTotal() {
        // Get the selected shipping price
        var shippingPrice = 0;
        var shippingOption = $("input[name='shipping']:checked").attr("id");
        if (shippingOption === "standard-shipping") {
          shippingPrice = 10.00;
        } else if (shippingOption === "express-shipping") {
          shippingPrice = 20.00;
        }

        // Get the current subtotal value
        var subtotal = parseFloat($("#subtotal").text().replace(",", ""));

        // Calculate the total by adding the shipping price to the subtotal
        var total = subtotal + shippingPrice;

        // Update the total amount in the HTML
        var formattedTotal = total.toLocaleString(undefined, { minimumFractionDigits: 2 });
        $(".summary-total td:last-child").text("$" + formattedTotal);
      }

      // Add event listener to the shipping options
      $(".shipping-option").on("change", function () {
        updateTotal();
      });

      // Call the updateTotal function initially to set the default total
      updateTotal();

      $(".ddlQuantity").on("change", function() {
        // Get the index of the changed dropdown list
        var index = $(this).data("index");
        
        // Get the selected quantity
        var selectedQuantity = parseInt($(this).val());

        // Update the total based on the shipping option
        updateTotal();
    });
});
      </script>
  </head>

  <body style="background-color: #f3f3f3;">

  <?php require_once "navigation.php"; ?>



  
      <div class="col-lg-12" style="margin-top:20px;">
          <!-- <h1 class="page-header text-center">Cart Details</h1> -->
          <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
                  <?php if (isset($_SESSION["message"])) { ?>
                      <div class="alert alert-info text-center">
                          <?php echo $_SESSION["message"]; ?>
                      </div>
                  <?php unset($_SESSION["message"]);} ?>
                  <form>
       
                  <div>
    
       

                  <div class="col-lg-9 summary" style="background-color: white;">
                  <h2><b>MY BAG</b></h2>
                  <table class="table">
      
          <tbody>
            <?php
            //initialize total
            $total = 0;
            if (!empty($_SESSION["cart"])) {
              //connection
              $conn = new mysqli(
                "localhost:3307",
                "root",
                "123456",
                "cartexample"
              );

              //create array of initail qty which is 1
              $index = 0;
              if (!isset($_SESSION["qty_array"])) {
                $_SESSION["qty_array"] = array_fill(0, count($_SESSION["cart"]), 1);
              }
              $sql ="SELECT * FROM products WHERE ProductId IN (" . implode(",", $_SESSION["cart"]) . ")";
              $dbHelper->execute($sql);
              $result = $dbHelper->getResult();

              foreach($result as $row) { ?>
                  <tr>
                    <td colspan="1" style="width: 240px;">
                        <img src="<?php echo $row["ProductImage"]; ?>" width="200" height="200" alt="<?php echo $row["ProductName"]; ?>">
                    </td>
                    <td colspan="12" style="width: 440px;">
                        <?php echo "<h4><b>$" . number_format($row["Price"], 2) ."</b></h4>" .
                         "<h4>" . $row["ProductName"] . "</h4>" .
                          "<br>"; ?>
                          <div class="quantity-container">
                            <span class="qty-label">Qty</span>
                            <select class="form-control ddlQuantity" name="qty_<?php echo $index; ?>">
                              <?php
                              for ($quantity = 1; $quantity <= 10; $quantity++) {
                                  $selected = ($_SESSION["qty_array"][$index] == $quantity) ? "selected" : "";
                                  echo "<option value='$quantity' $selected>$quantity</option>";
                              }
                              ?>
                            </select>
                          </div>
                        <!-- <input type="text" class="form-control" style="width:33%;" value="<?php echo $_SESSION["qty_array"][$index]; ?>" name="qty_<?php echo $index; ?>">  -->
                        <br> 
                        <button type="button" class="btn-save-for-later"><i class="fa fa-heart-o"></i> Save for Later</button>
                    </td>

                    
                    <?php $total += ($_SESSION["qty_array"] != null) ? $_SESSION["qty_array"][$index] * $row["Price"] : 0; ?>
                    <td colspan="1">
                      <a href="delete_cart.php?id=<?php echo $row['ProductId']; ?>&index=<?php echo $index; ?>" class="btn btn-sm">
                        <span><i class="fa fa-times" style="font-size:20px; color:black;"></i></span>  
                      </a>
                    </td>
                  </tr>
                  <?php $index++;}
            } else {
               ?>
                <tr>
                  <td colspan="11" class="text-center">No Item in Cart</td>
                </tr>
                <?php
            }
            ?>
            <!-- <tr>
              <td colspan="1" align="right"><b>Total</b></td>
              <td><b><?php echo number_format($total, 2); ?></b></td>
            </tr> -->
          </tbody>
        </table>

        </div>
</div>

<aside class="col-lg-3">
	                			<div class="summary summary-cart">
	                				<h2 class="summary-title">Cart Total</h2><!-- End .summary-title -->

	                				<table class="table table-summary">
	                					<tbody>
	                						<tr class="summary-subtotal">
	                							<td>Subtotal:</td>
	                							<td id="subtotal"><?php echo number_format($total, 2); ?></td>
                                
	                						</tr><!-- End .summary-subtotal -->
	                						<tr class="summary-shipping">
	                							<td>Shipping:</td>
	                							<td>&nbsp;</td>
	                						</tr>

	                						<tr class="summary-shipping-row">
	                							<td>
													<div class="custom-control custom-radio">
                            <input type="radio" id="free-shipping" name="shipping" class="custom-control-input shipping-option" checked>
														<label class="custom-control-label" for="free-shipping">Free Shipping</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>$0.00</td>
	                						</tr><!-- End .summary-shipping-row -->

	                						<tr class="summary-shipping-row">
	                							<td>
	                								<div class="custom-control custom-radio">
														<input type="radio" id="standard-shipping" name="shipping" class="custom-control-input shipping-option">
														<label class="custom-control-label" for="standard-shipping">Standart:</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>$10.00</td>
	                						</tr><!-- End .summary-shipping-row -->

	                						<tr class="summary-shipping-row">
	                							<td>
	                								<div class="custom-control custom-radio">
														<input type="radio" id="express-shipping" name="shipping" class="custom-control-input shipping-option">
														<label class="custom-control-label" for="express-shipping">Express:</label>
													</div><!-- End .custom-control -->
	                							</td>
	                							<td>$20.00</td>
	                						</tr><!-- End .summary-shipping-row -->

	                						<tr class="summary-total">
	                							<td>Total:</td>
	                							<td>$160.00</td>
	                						</tr><!-- End .summary-total -->
	                					</tbody>
	                				</table><!-- End .table table-summary -->

	                				<a href="checkout.html" class="btn btn-success btn-order btn-block">PROCEED TO CHECKOUT</a>
	                			</div><!-- End .summary -->

		            			<a href="products.php" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
	                		</aside><!-- End .col-lg-3 -->
        </form>
              </div>
          </div>
      </div>
  </body>
</html>
