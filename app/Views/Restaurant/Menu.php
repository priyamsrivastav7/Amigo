<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f8f9fa;
            min-height: 100vh;
            padding-bottom: 80px; /* Added to accommodate the total bar */
        }

        .navbar {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar ul {
            max-width: 1200px;
            margin: 0 auto;
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 0 1rem;
        }

        .navbar li button {
            background: none;
            border: none;
            cursor: pointer;
            color: #2d3436;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
            font-family: 'Poppins', sans-serif;
        }

        .navbar li button.active {
            color: #ff6b6b;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            background: #ff6b6b;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .quantity-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .quantity-btn:hover:not(:disabled) {
            background: #ff5252;
        }

        .quantity-display {
            font-size: 1.1rem;
            font-weight: 500;
            min-width: 30px;
            text-align: center;
        }

        .total-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 1rem;
            box-shadow: 0 -2px 20px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .total-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1rem;
        }

        .total-items {
            font-size: 1.1rem;
            color: #2d3436;
        }

        .total-price {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ff6b6b;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f8f9fa;
            min-height: 100vh;
            padding-bottom: 2rem;
        }

        .navbar {
            background: white;
            padding: 1rem 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar ul {
            max-width: 1200px;
            margin: 0 auto;
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 0 1rem;
        }

        .navbar li button {
            background: none;
            border: none;
            cursor: pointer;
            color: #2d3436;
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
            font-family: 'Poppins', sans-serif;
        }

        .navbar li button.active {
            color: #ff6b6b;
        }

        .navbar li button.active::after {
            width: 80%;
        }

        .navbar li button::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #ff6b6b;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar li button:hover {
            color: #ff6b6b;
        }

        .navbar li button:hover::after {
            width: 80%;
        }

        .menu-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: #2d3436;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
        }

        h2::after {
            content: '';
            display: block;
            width: 80px;
            height: 3px;
            background: #ff6b6b;
            margin: 1rem auto;
        }

        .menu-items {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .menu-item {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .menu-item-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 3px solid #ff6b6b;
        }

        .item-info {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .item-info h3 {
            font-size: 1.4rem;
            color: #2d3436;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .item-info p {
            color: #636e72;
            font-size: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .item-info p:nth-child(2) {
            color: #ff6b6b;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        .price {
            font-size: 1.2rem !important;
            color: #2d3436 !important;
            font-weight: 600;
            margin-top: auto;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
            display: none;
        }

        .empty-state p {
            font-size: 1.2rem;
            color: #636e72;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .navbar ul {
                flex-wrap: wrap;
                gap: 1rem;
            }

            .navbar li button {
                font-size: 1rem;
                padding: 0.5rem 1rem;
            }

            h2 {
                font-size: 2rem;
            }

            .menu-items {
                grid-template-columns: 1fr;
            }

            .menu-item {
                margin: 0 1rem;
            }
            
        }
        .navbar ul li:first-child button {
    color: #5a3f2f; /* Rich, deep brown tone */
    font-weight: 500;
    background-color: transparent;
    border: 1px solid #8b6b4f; /* Soft, warm border */
    border-radius: 4px;
    padding: 10px 20px;
    font-family: 'Optima', 'Palatino Linotype', serif;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    transition: all 0.3s ease-in-out;
    position: relative;
    overflow: hidden;
    outline: none;
}

.navbar ul li:first-child button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        120deg, 
        transparent, 
        rgba(139, 107, 79, 0.1), 
        transparent
    );
    transition: all 0.4s ease-in-out;
}

.navbar ul li:first-child button:hover {
    color: #ffffff;
    background-color: #5a3f2f;
    border-color: #5a3f2f;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.navbar ul li:first-child button:hover::before {
    left: 100%;
}

.navbar ul li:first-child button:active {
    transform: scale(0.98);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

    </style>
</head>
<body>
    <!-- Your existing navbar and menu container HTML remains the same -->
    <nav class="navbar">
        <ul>
            <li><button onclick="window.history.back()">Back</button></li>
            <li><button onclick="filterItems('All')" class="active">All</button></li>
            <li><button onclick="filterItems('Beverages')">Beverages</button></li>
            <li><button onclick="filterItems('Starter')">Starter</button></li>
            <li><button onclick="filterItems('Main Course')">Main Course</button></li>
            <li><button onclick="filterItems('Dessert')">Dessert</button></li>
        </ul>
    </nav>

    <div class="menu-container">
        <h2 id="category-title">All Menu Items</h2>
        <div class="menu-items" id="menu-items-container">
            <!-- Menu items will be dynamically populated here -->
        </div>
        <div class="empty-state">
            <p>No items available in this category at the moment.</p>
            <p>👨‍🍳</p>
        </div>
    </div>

    <div class="total-bar" id="total-bar">
        <div class="total-content">
            <div class="total-items">Items: <span id="total-items-count">0</span></div>
            <div class="total-price">Total: Rs. <span id="total-price-amount">0</span></div>
            <button id="checkout-btn" onclick="proceedToCheckout()">Proceed to Checkout</button>
        </div>
    </div>

    <script>
        function proceedToCheckout() {
        // Send cart data to the server
        const cartData = JSON.stringify(cart);
        // console.log(cartData);
        
        // Redirect to the checkout page with cart data
        fetch('<?= base_url('customer/checkout') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: cartData
        })
        .then(response => response.json())
                //console.log(response);
        
          .then(data => {
              if (data.success) {
                  window.location.href = '<?= base_url('customer/checkout') ?>'; // Redirect to checkout page
              } else {
                  alert('There was an error. Please try again.');
              }
          });
    }
    const menuItems = {
        'Beverages': [],
        'Starter': [],
        'Main Course': [],
        'Dessert': []
    };

    // Populate menuItems with PHP data
    <?php foreach ($menuItems as $item): ?>
    menuItems['<?= esc($item['type']) ?>'].push({
        id: '<?= esc($item['id']) ?>', // Ensure unique ID is passed
        name: '<?= esc($item['name']) ?>',
        type: '<?= esc($item['type']) ?>',
        price: <?= esc($item['price']) ?>,
        photo: '<?= base_url($item['photo']) ?>',
        quantity_limit: <?= esc($item['quantity_limit']) ?>
    });
    <?php endforeach; ?>

    const cart = {};

    function updateQuantity(itemId, increment) {
        // Find the item from menuItems
        const item = Object.values(menuItems)
            .flat()
            .find(item => item.id === itemId);

        if (!item) return;

        // Initialize item in cart if not already added
        if (!cart[itemId]) {
            cart[itemId] = { ...item, quantity: 0 };
        }

        // Update quantity in the cart
        if (increment && cart[itemId].quantity < item.quantity_limit) {
            cart[itemId].quantity++;
        } else if (!increment && cart[itemId].quantity > 0) {
            cart[itemId].quantity--;
        }

        updateTotalBar();
        updateItemDisplay(itemId);
    }

    function updateTotalBar() {
        const totalBar = document.getElementById('total-bar');
        const totalItems = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
        const totalPrice = Object.values(cart).reduce((sum, item) => sum + (item.price * item.quantity), 0);

        document.getElementById('total-items-count').textContent = totalItems;
        document.getElementById('total-price-amount').textContent = totalPrice.toFixed(2);
        totalBar.style.display = totalItems > 0 ? 'block' : 'none';
    }

    function updateItemDisplay(itemId) {
        const quantityDisplay = document.getElementById(`quantity-${itemId}`);
        const minusBtn = document.getElementById(`minus-${itemId}`);
        const plusBtn = document.getElementById(`plus-${itemId}`);
        const item = cart[itemId];

        if (quantityDisplay) {
            quantityDisplay.textContent = item ? item.quantity : 0;
            minusBtn.disabled = !item || item.quantity === 0;
            plusBtn.disabled = item && item.quantity >= menuItems[item.type].find(i => i.id === itemId).quantity_limit;
        }
    }

    function filterItems(category) {
        // Update active button
        document.querySelectorAll('.navbar button').forEach(btn => {
            btn.classList.remove('active');
            if (btn.textContent === category) {
                btn.classList.add('active');
            }
        });

        // Update category title
        document.getElementById('category-title').textContent = category === 'All' ? 'All Menu Items' : category;

        // Get items to display
        let itemsToDisplay = [];
        if (category === 'All') {
            Object.values(menuItems).forEach(categoryItems => {
                itemsToDisplay = itemsToDisplay.concat(categoryItems);
            });
        } else {
            itemsToDisplay = menuItems[category] || [];
        }

        // Display items
        const container = document.getElementById('menu-items-container');
        const emptyState = document.querySelector('.empty-state');

        if (itemsToDisplay.length === 0) {
            container.style.display = 'none';
            emptyState.style.display = 'block';
        } else {
            container.style.display = 'grid';
            emptyState.style.display = 'none';

            container.innerHTML = itemsToDisplay.map(item => `
                <div class="menu-item">
                    <img src="${item.photo}" alt="${item.name}" class="menu-item-image">
                    <div class="item-info">
                        <h3>${item.name}</h3>
                        <p>${item.type}</p>
                        <p class="price">Rs. ${item.price}</p>
                        <div class="quantity-controls">
                            <button 
                                id="minus-${item.id}" 
                                class="quantity-btn" 
                                onclick="updateQuantity('${item.id}', false)" 
                                disabled
                            >-</button>
                            <span id="quantity-${item.id}" class="quantity-display">0</span>
                            <button 
                                id="plus-${item.id}" 
                                class="quantity-btn" 
                                onclick="updateQuantity('${item.id}', true)"
                            >+</button>
                        </div>
                    </div>
                </div>
            `).join('');

            // Restore quantities for items in cart
            itemsToDisplay.forEach(item => {
                if (cart[item.id]) {
                    updateItemDisplay(item.id);
                }
            });
        }
    }

    // Initialize with all items
    filterItems('All');
    

</script>

</body>
</html>