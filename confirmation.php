<!DOCTYPE html>
<html>
    <head>
        <style>
            body{
                font-family: sans-serif
            }
            .confirmation-container{
                text-align:center
            }

            .confirmation-txt{
                width: 50%;
                margin: auto;
            }

            .btn-receipt{
                background-color: #024e4a;
                border: none;
                color: white;
                margin-top: 2em;
                padding: 15px;
                border-radius: 5px;
            }

            .return-policy-link{
                display: block;
                margin-top: 3em;
                color: black;
                font-size: 13px;
            }

            .card-container{
                text-align: center;
                margin-top: 4em;
                justify-content: center;
                column-gap: 80px;
                display: flex;
            }

            .card{
                border-radius: 6px;
                background: lightgray;
                padding: 10px 30px;
                width: 5em;
            }

            .card-img{
                width: 50px;
            }
        </style>
    </head>
    <body>
        <div class="confirmation-container">
            <h4>HomeDecor.com/CHECKOUT</h4>
            <h1>THANK YOU!</h1>
            <p class="confirmation-txt">Thank you for choosing us to add a touch of elegance to your home! Our curated selection of exquisite decor will turn your space into a personalized oasis. Embrace the beauty of every moment as you bask in the ambiance of your newly adorned surroundings. Happy decorating!</p>
            <button class="btn-receipt">VIEW ORDER RECEIPT</button>
            <a href="#" class="return-policy-link">Read about our return policy</a>
        </div>
        <div class="card-container">
        <div class="card">
            <div class="card-body">
                <img src="./images/shipped.png" class="card-img"/>
                <h4 class="card-subtitle mb-2 text-muted">DELIVERY</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <img src="./images/credit-card.png" class="card-img"/>
                <h4 class="card-subtitle mb-2 text-muted">PAYMENTS</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <img src="./images/return.png" class="card-img"/>
                <h4 class="card-subtitle mb-2 text-muted">RETURNS</h4>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <img src="./images/customer.png" class="card-img"/>
                <h4 class="card-subtitle mb-2 text-muted">CUSTOMER SERVICE</h4>
            </div>
        </div>
    </body>
</html>