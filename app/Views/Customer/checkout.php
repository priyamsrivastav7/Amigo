<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5af19, #f12711);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
            color: #333;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            /* color: #fff; */
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .checkout-container {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 800px;
        }

        .checkout-items {
            margin-bottom: 2rem;
        }

        .checkout-item {
            display: flex;
            align-items: center;
            background: #f9f9f9;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .checkout-item-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 1rem;
        }

        .checkout-item-info {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 1;
        }

        .checkout-item-info h3 {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .checkout-item-info p {
            font-size: 0.95rem;
            color: #555;
        }

        .checkout-summary {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid #ddd;
        }

        .checkout-summary p {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        button {
            background: linear-gradient(135deg, #f12711, #f5af19);
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background: linear-gradient(135deg, #f5af19, #f12711);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .checkout-item {
                flex-direction: column;
                text-align: center;
            }

            .checkout-item-image {
                margin: 0 auto 1rem;
            }

            .checkout-summary p {
                font-size: 1.2rem;
            }
        }
        .back-button-container {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .back-button {
            background: transparent;
            color: #333;
            border: 1px solid #333;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: none;
        }

        .back-button:hover {
            background: rgba(0,0,0,0.05);
            transform: translateX(-3px);
            box-shadow: none;
        }

        .back-button svg {
            width: 1.2rem;
            height: 1.2rem;
        }

        .checkout-container {
            position: relative;
        }

        @media (max-width: 768px) {
            .back-button-container {
                position: static;
                text-align: center;
                margin-bottom: 1rem;
            }
        }
    </style>

</head>
<body>
    
        

    <div class="checkout-container">
    <div class="back-button-container">
            <button onclick="window.history.back()" class="back-button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </button>
        </div>
        <h2>Checkout</h2>
        <div class="checkout-items">
            <?php if ($cartData): ?>
                <?php foreach ($cartData as $itemId => $item): ?>
                    <div class="checkout-item">
                        <img src="<?= esc($item['photo']) ?>" alt="<?= esc($item['name']) ?>" class="checkout-item-image">
                        <div class="checkout-item-info">
                            <h3><?= esc($item['name']) ?></h3>
                            <p>Quantity: <?= esc($item['quantity']) ?></p>
                            <p>Total Price: Rs. <?= number_format(esc($item['quantity']) * esc($item['price']), 2) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No items in your cart.</p>
            <?php endif; ?>
        </div>

        <!-- In your view file (checkout.php or similar) -->
        <div class="checkout-summary">
    <p>Total: Rs. 
        <?php 
        $total = 0;
        foreach ($cartData as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        echo number_format($total, 2);
        ?>
    </p>

    <!-- Create a form that will submit to the payment initiation method -->
    <form action="<?= site_url('initiate-payment') ?>" method="post">
        <input type="hidden" name="total" value="<?= number_format($total, 2) ?>">
        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
    </form>
</div>
    </div>

</body>
</html>
