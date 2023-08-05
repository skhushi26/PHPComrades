<?php
session_start();

// Access the stored values
$subtotal = $_SESSION["subtotal"];
$shipping = $_SESSION["shipping"];
$total = $_SESSION["total"];
?>

<!-- ... (your HTML code) -->

<!-- Display the values -->
<p>Subtotal: $<?php echo $subtotal; ?></p>
<p>Shipping: $<?php echo $shipping; ?></p>
<p>Total: $<?php echo $total; ?></p>

?>