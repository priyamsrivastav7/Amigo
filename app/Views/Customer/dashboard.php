<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        /* Existing CSS styles */
        /* ... */

        /* New styles for the Favorite button */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f8f9fa;
            min-height: 100vh;
            padding: 2rem;
            color: #2d3436;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: #2d3436;
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        h2::after {
            content: '👋';
            font-size: 2rem;
            margin-left: 1rem;
            animation: wave 2s infinite;
        }

        h3 {
            font-size: 1.8rem;
            color: #ff6b6b;
            margin: 2rem 0;
            font-weight: 600;
        }

        .restaurant-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .restaurant-item {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .restaurant-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .restaurant-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 4px solid #ff6b6b;
        }

        .restaurant-item h4 {
            font-size: 1.4rem;
            padding: 1rem 1.5rem;
            color: #2d3436;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .restaurant-item p {
            padding: 0.3rem 1.5rem;
            color: #636e72;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .restaurant-item p strong {
            color: #2d3436;
            min-width: 70px;
        }

        .view-menu-button {
            display: block;
            margin: 1.5rem;
            padding: 1rem;
            background: linear-gradient(45deg, #ff6b6b, #ffd93d);
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .view-menu-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: 0.5s;
        }

        .view-menu-button:hover::before {
            left: 100%;
        }

        .view-menu-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .logout-container {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 100;
        }

        .logout-button {
            padding: 0.8rem 2rem;
            background: white;
            border: 2px solid #ff6b6b;
            color: #ff6b6b;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-button:hover {
            background: #ff6b6b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.2);
        }

        /* Empty state styling */
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .empty-state p {
            font-size: 1.2rem;
            color: #636e72;
            margin-bottom: 1rem;
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(20deg); }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            h2 {
                font-size: 2rem;
            }

            h3 {
                font-size: 1.5rem;
            }

            .restaurant-list {
                grid-template-columns: 1fr;
            }

            .logout-container {
                position: static;
                margin-top: 2rem;
                text-align: center;
            }
        }

        /* Loading skeleton animation */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .range-slider {
            width: 100%;
            margin-bottom: 2rem;
        }

        .range-slider__range {
            -webkit-appearance: none;
            width: 10%;
            height: 10px;
            border-radius: 5px;
            background: #d7dcdf;
            outline: none;
            padding: 0;
            margin: 0;
        }

        .range-slider__range::-webkit-slider-thumb {
            appearance: none;
            width: 20px;
            height: 20px;
            background: #ff6b6b;
            cursor: pointer;
            -webkit-transition: background 0.15s ease-in-out;
            transition: background 0.15s ease-in-out;
        }

        .range-slider__range::-webkit-slider-thumb:hover {
            background: #ffd93d;
        }

        .range-slider__range:active::-webkit-slider-thumb {
            background: #ffd93d;
        }

        .range-slider__value {
            display: inline-block;
            width: 60px;
            color: #ff6b6b;
            line-height: 20px;
            text-align: center;
            border-radius: 3px;
            background: #d7dcdf;
            padding: 5px 5px;
            margin-left: 8px;
        }

        .range-slider__value:after {
            position: absolute;
            top: 8px;
            left: -7px;
            width: 0;
            height: 0;
            border-top: 7px solid transparent;
            border-right: 7px solid #d7dcdf;
            border-bottom: 7px solid transparent;
            content: "";
        }
        .heart-button {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #ccc;
    transition: transform 0.2s ease;
    padding: 0.5rem;
    z-index: 10;
}

.heart-button.favorited {
    color: red;
}

.heart-button:hover {
    transform: scale(1.2);
}

.restaurant-item {
    position: relative;
}

.favorites-section {
    margin: 2rem 0;
}

.favorites-section h2 {
    color: #ff4646;
    margin-bottom: 1rem;
}
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?= session()->get('customer_name'); ?>!</h2>
        <h3>Explore Our Partner Restaurants</h3>

        <div class="range-slider">
            <input type="range" min="1" max="20" value="1" class="range-slider__range" id="range-slider">
            <span class="range-slider__value" id="range-value">1 km</span>
        </div>
        <!-- <div id="favorites-container" class="favorites-section">
        
        <?php if (!empty($favorites)): ?>
            <h3>Your Favorites</h3>
            <div class="restaurant-list">
                <?php foreach ($favorites as $restaurant): ?>
                    <div class="restaurant-item">
                        <img src="<?= base_url('/' . $restaurant['image']); ?>" alt="<?= $restaurant['name']; ?>" class="restaurant-image">
                        <h4><?= $restaurant['name']; ?></h4>
                        <p><strong>Email:</strong> <?= $restaurant['email']; ?></p>
                        <p><strong>Phone:</strong> <?= $restaurant['phone_number']; ?></p>
                        <p><strong>Address:</strong> <?= $restaurant['address']; ?></p>
                        <a href="/customer/menu/<?= $restaurant['id']; ?>" class="view-menu-button">View Menu</a>
                        <button type="button" class="heart-button favorited" data-id="<?= $restaurant['id']; ?>">♥</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </div> -->



        <h3>All Restaurants</h3>
        

        <div class="restaurant-list" id="restaurant-list">
        <?php foreach($restaurants as $restaurant): ?>
            <div class="restaurant-item" 
                data-latitude="<?= $restaurant['latitude']; ?>" 
                data-longitude="<?= $restaurant['longitude']; ?>" 
                data-id="<?= $restaurant['id']; ?>">
                <img src="<?= base_url('/' . $restaurant['image']); ?>" alt="<?= $restaurant['name']; ?>" class="restaurant-image">
                <h4><?= $restaurant['name']; ?></h4>
                <p><strong>Email:</strong> <?= $restaurant['email']; ?></p>
                <p><strong>Phone:</strong> <?= $restaurant['phone_number']; ?></p>
                <p><strong>Address:</strong> <?= $restaurant['address']; ?></p>
                <p><strong>Status:</strong> <?= $restaurant['status'] ? 'Open' : 'Closed'; ?></p>
                
                <?php if ($restaurant ['status'] == 1): ?>
                <a href="/customer/menu/<?= $restaurant['id']; ?>" class="view-menu-button">View Menu</a>
                <?php else: ?>
                    <button class="view-menu-button" disabled>Restaurant is currently closed</button>
                <?php endif; ?>

                <button class="heart-button <?= in_array($restaurant['id'], $favoriteIds) ? 'favorited' : '' ?>" 
    data-id="<?= $restaurant['id'] ?>">
    ♥
</button>

            </div>
        <?php endforeach; ?>
    </div>

        
    <div class="logout-container">
            <form action="/customer/logout" method="get">
                <button type="submit" class="logout-button">Logout</button>
            </form>
     </div>
    

     <script>
    document.addEventListener('DOMContentLoaded', () => {
    const rangeSlider = document.getElementById('range-slider');
    const rangeValue = document.getElementById('range-value');
    let customerLatitude, customerLongitude;

    // Geolocation and Distance Filtering
    navigator.geolocation.getCurrentPosition(
        (position) => {
            customerLatitude = position.coords.latitude;
            customerLongitude = position.coords.longitude;
            console.log(customerLatitude);
            console.log(customerLongitude);


            // Update the restaurant list based on the selected range
            updateRestaurantList(customerLatitude, customerLongitude, rangeSlider.value);

            // Add event listener to the range slider
            rangeSlider.addEventListener('input', () => {
                const range = rangeSlider.value;
                rangeValue.textContent = `${range} km`;
                updateRestaurantList(customerLatitude, customerLongitude, range);
            });
        },
        (error) => {
            console.error('Error getting customer location:', error);
        }
    );

    function updateRestaurantList(customerLatitude, customerLongitude, range) {
        const restaurantItems = document.querySelectorAll('.restaurant-item');
        restaurantItems.forEach((item) => {
            const restaurantLatitude = parseFloat(item.dataset.latitude);
            const restaurantLongitude = parseFloat(item.dataset.longitude);
            const distance = calculateDistance(customerLatitude, customerLongitude, restaurantLatitude, restaurantLongitude);
            
            if (distance <= range) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the earth in km
        const dLat = ((lat2 - lat1) * Math.PI) / 180;
        const dLon = ((lon2 - lon1) * Math.PI) / 180;
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos((lat1 * Math.PI) / 180) *
            Math.cos((lat2 * Math.PI) / 180) *
            Math.sin(dLon / 2) *
            Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Distance in km
    }

    // Favorite Toggle Functionality
    function favoriteHandler(event) {
        event.preventDefault();

        const button = event.currentTarget;
        const restaurantId = button.dataset.id;

        toggleFavorite(button, restaurantId);
    }

    async function toggleFavorite(button, restaurantId) {
        try {
            // Disable button during request to prevent multiple clicks
            button.disabled = true;

            const response = await fetch('/customer/toggleFavorite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ restaurant_id: restaurantId }),
                credentials: 'same-origin'
            });

            // Check if response is OK
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            if (data.status === 'added') {
                button.classList.add('favorited');
            } else if (data.status === 'removed') {
                button.classList.remove('favorited');
            } else if (data.status === 'error') {
                alert(data.message || 'An error occurred');
            }

            // Update favorites section if HTML is provided
            if (data.favorites_html) {
                const favoritesContainer = document.getElementById('favorites-container');
                if (favoritesContainer) {
                    favoritesContainer.innerHTML = data.favorites_html;
                    attachFavoriteListeners();
                }
            }
        } catch (error) {
            console.error('Error toggling favorite:', error);
            alert('Could not update favorites. Please try again.');
        } finally {
            // Re-enable button
            button.disabled = false;
        }
    }

    function attachFavoriteListeners() {
        document.querySelectorAll('.heart-button').forEach(button => {
            // Remove existing listeners first to prevent multiple attachments
            button.removeEventListener('click', favoriteHandler);
            button.addEventListener('click', favoriteHandler);
        });
    }

    // Initial attachment of favorite listeners
    attachFavoriteListeners();
});
</script>

</body>
</html>