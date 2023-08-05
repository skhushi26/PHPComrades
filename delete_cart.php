<?php
    session_start();
    
    // Remove the id from our cart array
    $key = array_search($_GET['id'], $_SESSION['cart']);	
    unset($_SESSION['cart'][$key]);

    // Remove the corresponding quantity from qty_array
    $productId = $_GET['id'];
     if (isset($_SESSION['qty_array'][$productId])) {
        unset($_SESSION['qty_array'][$productId]);
    }

    // Reorganize the qty_array to have continuous numeric indexes
    $_SESSION['qty_array'] = array_values($_SESSION['qty_array']);

    // Reset numeric keys of the cart array to ensure consistency
    $_SESSION['cart'] = array_values($_SESSION['cart']);

    $_SESSION['message'] = "Product deleted from cart";
    header('location: cart.php');
?>
