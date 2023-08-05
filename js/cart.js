$(document).ready(function () {
    $(".btn-save-for-later").click(function () { // Toggle the classes for the <i> element
        $(this).find("i").toggleClass("fa-heart-o fa-heart");
        $(this).toggleClass("btn-save-for-later-clicked");
    });


    // Function to calculate and update the total based on the shipping option
    function updateTotal() { // Get the selected shipping price
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
        var formattedTotal = total.toLocaleString(undefined, {minimumFractionDigits: 2});
        $(".summary-total td:last-child").text("$" + formattedTotal);
    }

    // Add event listener to the shipping options
    $(".shipping-option").on("change", function () {
        updateTotal();
    });

    // Call the updateTotal function initially to set the default total
    updateTotal();

    $(".ddlQuantity").on("change", function () { // Get the index of the changed dropdown list
        var index = $(this).data("index");

        // Get the selected quantity
        var selectedQuantity = parseInt($(this).val());

        // Update the total based on the shipping option
        updateTotal();
    });
});

function updateSubtotal(price, previous_quantity, quantity) {
    let subtotal = parseFloat($("#subtotal").text());
    quantity = parseInt(quantity);
    previous_quantity = parseInt(previous_quantity);
    price = parseFloat(price);
    subtotal += (quantity - previous_quantity) * price;
    
    // Update the displayed subtotal
    $('#subtotal').text(subtotal);
}
