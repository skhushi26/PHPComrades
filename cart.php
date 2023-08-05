<?php
  require_once "./dal/dbhelper.php";
  $dbHelper = new DBHelper();
  session_start();

  if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
  }

  if (!isset($_SESSION["qty_array"])) {
    $_SESSION["qty_array"] = [];
  }

  // DUMMY DATA
  // unset($_SESSION["cart"]);
  // unset($_SESSION["qty_array"]);

  // $_SESSION["cart"] = [1, 2, 3];
  // $_SESSION["qty_array"] = [
  //   1 => 2,
  //   2 => 4,
  //   3 => 7
  // ];

  if (isset($_GET["id"]) && isset($_GET["qty"])) {
    $product_id = $_GET["id"];
    $quantity = $_GET["qty"];

    if (!in_array($product_id, $_SESSION["cart"])) {
      array_push($_SESSION["cart"], $product_id);
      $_SESSION["qty_array"][$product_id] = $quantity;
    }
    header("location: index.php");
    exit();
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
      <script src="./js/cart.js"></script>
  </head>
  <body style="background-color: #f3f3f3;">
    <!-- NAVIGATION  -->
    <?php require_once "navigation.php"; ?>  
    <div class="col-lg-12" style="margin-top:20px;">
      <div class="row">
        <div class="col-sm-10 col-sm-offset-1">      
          <!-- INFORMATION MESSAGE  -->
          <?php if (isset($_SESSION["message"])) { ?>
            <div class="alert alert-info text-center">
              <?php echo $_SESSION["message"]; ?>
            </div>
          <?php unset($_SESSION["message"]);} ?>
    
          <form>
            <!-- MY BAG -->
            <div>
              <div class="col-lg-8 summary" style="background-color: white;">
                <h2><b>MY BAG</b></h2>

                <table class="table">
                  <tbody>
                    <?php
                    //initialize total
                    $total = 0;
                    if (!empty($_SESSION["cart"])) {
                        //create array of initail qty which is 1
                        $index = 0;
                        $sql = "SELECT * FROM products WHERE ProductId IN (" . implode(",", $_SESSION["cart"]) . ")";
                        $dbHelper->execute($sql);
                        $result = $dbHelper->getResult();

                        foreach ($result as $row) { ?>
                            <?php
                                // Get the product ID for this row
                                $productId = $row["ProductId"];

                                // Set the default quantity value if not set in the session
                                if (!isset($_SESSION["qty_array"][$productId])) {
                                    $_SESSION["qty_array"][$productId] = 1;
                                }

                                // Update the selected quantity if the form was submitted
                                if (isset($_POST["qty_$index"])) {
                                    $_SESSION["qty_array"][$productId] = intval($_POST["qty_$index"]);
                                }

                                $total += $_SESSION["qty_array"] != null ? $_SESSION["qty_array"][$row["ProductId"]]*$row["Price"] : 0;
                            ?>

                            <tr>
                                <!-- PRODUCT IMAGE -->
                                <td colspan="1" style="width: 240px;">
                                    <img src="<?php echo $row["ProductImage"]; ?>" width="200" height="200" 
                                        alt="<?php echo $row["ProductName"] . " - " . $row["ProductDescription"]; ?>">
                                </td>

                                <!-- PRODUCT INFORMATION -->
                                <td colspan="12" style="width: 440px;">
                                    <?php
                                        echo "<h4><b>$" . number_format($row["Price"], 2) . "</b></h4>" . 
                                            "<h4>" . $row["ProductName"] . "</h4><br>"; 
                                    ?>
                                        
                                    <div class="quantity-container">
                                        <span class="qty-label">Qty</span>
                                        <select class="form-control ddlQuantity" name="qty_<?php echo $index; ?>" 
                                                onchange="updateSubtotal(<?php echo $row["Price"]; ?>, <?php echo $_SESSION["qty_array"][$row["ProductId"]]; ?>, this.value)">
                                        
                                        <?php
                                            $productId = $row["ProductId"];
                                            for ($quantity = 1; $quantity <= 10; $quantity++) {
                                                $selected = $_SESSION["qty_array"][$productId] == $quantity ? "selected" : "";
                                                echo "<option value='$quantity' $selected>$quantity</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    
                                    <br> 
                                    <button type="button" class="btn-save-for-later"><i class="fa fa-heart-o"></i> Save for Later</button>
                                </td>

                                <!-- DELETE PRODUCT  -->
                                <td colspan="1">
                                    <a href="delete_cart.php?id=<?php echo $row["ProductId"]; ?>&index=<?php echo $index; ?>" class="btn btn-sm">
                                        <span>
                                            <i class="fa fa-times" style="font-size:20px; color:black;"></i>
                                        </span>  
                                    </a>
                                </td>
                            </tr>

                            <?php $index++;
                        }
                    }
                    else { ?>
                        <tr>
                            <!-- IF THERE IS NO ITEM IN CART, THEN DISPLAY THIS MESSAGE IN TABLE -->
                            <td colspan="11" class="text-center">No Item in Cart</td>
                        </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- CART TOTAL MENU -->
            <aside class="col-lg-4">
              <div class="summary summary-cart">
                <h2 class="summary-title">Cart Total</h2>
                <table class="table table-summary">
                  <tbody>
                    <!-- SUBTOTAL -->
                    <tr class="summary-subtotal">
                      <td>Subtotal:</td>
                      <td id="subtotal"><?php echo number_format($total, 2); ?></td>
                    </tr>

                    <!-- SHIPPING -->
                    <tr class="summary-shipping">
                      <td>Shipping:</td>
                      <td>&nbsp;</td>
                    </tr>

                    <!-- FREE SHIPPING -->
                    <tr class="summary-shipping-row">
                      <td>
                        <div class="custom-control custom-radio">
                          <input type="radio" id="free-shipping" name="shipping" class="custom-control-input shipping-option" checked>
                          <label class="custom-control-label" for="free-shipping">Free Shipping</label>
                        </div>
                      </td>
                      <td>$0.00</td>
                    </tr>

                    <!-- STANDART SHIPPING -->
                    <tr class="summary-shipping-row">
                      <td>
                        <div class="custom-control custom-radio">
                          <input type="radio" id="standard-shipping" name="shipping" class="custom-control-input shipping-option">
                          <label class="custom-control-label" for="standard-shipping">Standart:</label>
                        </div>
                      </td>
                      <td>$10.00</td>
                    </tr>

                    <!-- EXPRESS SHIPPING -->
                    <tr class="summary-shipping-row">
                      <td>
                        <div class="custom-control custom-radio">
                          <input type="radio" id="express-shipping" name="shipping" class="custom-control-input shipping-option">
                          <label class="custom-control-label" for="express-shipping">Express:</label>
                        </div>
                      </td>
                      <td>$20.00</td>
                    </tr>

                    <!-- TOTAL -->
                    <tr class="summary-total">
                      <td>Total:</td>
                      <td>$160.00</td>
                    </tr>

                  </tbody>
                </table>

                <?php
                $_SESSION["subtotal"] = $total;
                $_SESSION["shipping"] = 10.0; // Replace with actual shipping cost calculation
                $_SESSION["total"] =
                  $_SESSION["subtotal"] + $_SESSION["shipping"];
                ?>
                
                <a href="checkout.php" class="btn btn-success btn-order btn-block">PROCEED TO CHECKOUT</a>
              </div>

              <a href="products.php" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
            </aside>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
