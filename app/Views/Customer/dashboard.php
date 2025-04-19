<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Customer Dashboard</title>
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap"
		rel="stylesheet">
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
			padding-bottom: 2rem;
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

			0%,
			100% {
				transform: rotate(0deg);
			}

			50% {
				transform: rotate(20deg);
			}
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
			0% {
				background-position: -1000px 0;
			}

			100% {
				background-position: 1000px 0;
			}
		}

		.range-slider {
			width: 100%;
			margin-bottom: 1rem;
		}

		.range-slider__range {
			-webkit-appearance: none;
			width: 80%;
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

		.settings-logout-container {
			display: flex;
			align-items: center;
			gap: 1rem;
			position: fixed;
			top: 2rem;
			right: 2rem;
			z-index: 100;
		}

		.settings-button {
			padding: 0.8rem;
			background: white;
			border: 2px solid #2d3436;
			color: #2d3436;
			border-radius: 12px;
			display: flex;
			align-items: center;
			justify-content: center;
			cursor: pointer;
			transition: all 0.3s ease;
			width: 50px;
			height: 50px;
		}

		.settings-button:hover {
			background: #2d3436;
			color: white;
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(45, 52, 54, 0.2);
		}

		.settings-button svg {
			width: 24px;
			height: 24px;
		}

		@media (max-width: 768px) {
			.settings-logout-container {
				position: static;
				margin-top: 2rem;
				justify-content: center;
			}
		}

		.settings-button {
			position: relative;
		}

		.settings-dropdown {
			position: absolute;
			top: 100%;
			right: 0;
			background: white;
			border-radius: 12px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
			width: 250px;
			margin-top: 10px;
			opacity: 0;
			visibility: hidden;
			transform: translateY(-10px);
			transition: all 0.3s ease;
			z-index: 100;
			border: 1px solid #e0e0e0;
		}

		.settings-button.active .settings-dropdown {
			opacity: 1;
			visibility: visible;
			transform: translateY(0);
		}

		.settings-dropdown-item {
			display: flex;
			align-items: center;
			padding: 1rem;
			text-decoration: none;
			color: #2d3436;
			transition: all 0.3s ease;
			border-bottom: 1px solid #f1f2f6;
		}

		.settings-dropdown-item:last-child {
			border-bottom: none;
		}

		.settings-dropdown-item:hover {
			background-color: #f8f9fa;
		}

		.settings-dropdown-item svg {
			width: 24px;
			height: 24px;
			margin-right: 1rem;
			color: #ff6b6b;
		}

		/* Overlay to close dropdown when clicking outside */
		.settings-dropdown-overlay {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: 50;
			display: none;
		}

		.settings-button.active+.settings-dropdown-overlay {
			display: block;
		}

		/* Reset some default styles */
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: Arial, sans-serif;
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

		.navbar-logo img {
			width: 120px;
			height: auto;
			border-radius: 8px;
			cursor: pointer;
			transition: transform 0.2s ease, box-shadow 0.2s ease;
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
		}


		/* Optional: Add spacing between elements */
		.navbar ul {
			margin: 0 10px;
		}
		/* Style for the search form container */
.search-form {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px auto;
    width: 100%;
    max-width: 600px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Style for the search input */
.search-input {
    flex: 1;
    padding: 12px 20px;
    border: none;
    outline: none;
    font-size: 16px;
    border-radius: 30px 0 0 30px;
    color: #333;
}

/* Style for the search button */
.search-button {
    padding: 12px 20px;
    background-color: #ff6b6b;
    border: none;
    outline: none;
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 0 30px 30px 0;
    transition: background-color 0.3s ease;
}

/* Hover effect for the search button */
.search-button:hover {
    background-color: #ff6b6b;
}

/* Responsive design for smaller screens */
@media (max-width: 768px) {
    .search-form {
        flex-direction: column;
        max-width: 100%;
    }
    .search-input {
        border-radius: 30px;
        margin-bottom: 10px;
    }
    .search-button {
        border-radius: 30px;
    }
}

	</style>
</head>
<nav class="navbar">
	<ul>

		<ul class="navbar-logo">
			<a href="/customer/dashboard">
				<img src="<?= base_url('/logo/dashboard-icon.png'); ?>" alt="Dashboard" class="navbar-logo-image">
			</a>
		</ul>
		<ul>
		<form method="GET" action="/search" class="search-form">
    <input type="text" name="query" class="search-input" placeholder="Search restaurants or dishes..." required>
    <button type="submit" class="search-button">Search</button>
</form>


		</ul>
		<ul>
			<div class="settings-logout-container">
				<div class="settings-button" id="settingsButton">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
					</svg>

					<div class="settings-dropdown">
						<a href="/customer/editprofile" class="settings-dropdown-item">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
							</svg>
							Profile Settings
						</a>

						<a href="javascript:void(0);" class="settings-dropdown-item" id="distance-preferences-toggle">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
    Distance Preferences
</a>

<!-- Range Slider - Hidden by default -->
<div class="range-slider" id="range-slider-container" style="display: none;">
    <input type="range" min="1" max="20" value="1" class="range-slider__range" id="range-slider">
    <span class="range-slider__value" id="range-value">1 km</span>
</div>

<script>
    // Select DOM elements
    const rangeSliderToggle = document.getElementById('distance-preferences-toggle');
    const rangeSliderContainer = document.getElementById('range-slider-container');
    const rangeSlider = document.getElementById('range-slider');
    const distanceValue = document.getElementById('range-value');

    // Toggle visibility of the range slider
    rangeSliderToggle.addEventListener('click', function () {
        if (rangeSliderContainer.style.display === 'none' || rangeSliderContainer.style.display === '') {
            rangeSliderContainer.style.display = 'block'; // Show the range slider
        } else {
            rangeSliderContainer.style.display = 'none'; // Hide the range slider
        }
    });

    // Update slider value and save it in localStorage
    rangeSlider.addEventListener('input', function () {
        const sliderValue = rangeSlider.value;
        localStorage.setItem('sliderValue', sliderValue);
        distanceValue.textContent = sliderValue + ' km';
    });

    // Load saved slider value from localStorage on page load
    window.onload = function () {
        const savedValue = localStorage.getItem('sliderValue');
        if (savedValue !== null) {
            rangeSlider.value = savedValue;
            distanceValue.textContent = savedValue + ' km';
        }
    };
</script>
					</div>
				</div>

				<form action="/customer/logout" method="get">
					<button type="submit" class="logout-button">Logout</button>
				</form>
			</div>
			<div class="settings-dropdown-overlay" id="settingsDropdownOverlay"></div>
			</div>
		</ul>

	</ul>
</nav>


<div class="dashboard-container">
	<h3>All Restaurants</h3>
	<div class="restaurant-list" id="restaurant-list">
		<?php foreach ($restaurants as $restaurant): ?>
			<div class="restaurant-item" data-latitude="<?= $restaurant['latitude']; ?>"
				data-longitude="<?= $restaurant['longitude']; ?>" data-id="<?= $restaurant['id']; ?>">
				<img src="<?= base_url('/' . $restaurant['image']); ?>" alt="<?= $restaurant['name']; ?>"
					class="restaurant-image">
				<h4><?= $restaurant['name']; ?></h4>
				<p><strong>Email:</strong> <?= $restaurant['email']; ?></p>
				<p><strong>Phone:</strong> <?= $restaurant['phone_number']; ?></p>
				<p><strong>Address:</strong> <?= $restaurant['address']; ?></p>
				<p><strong>Status:</strong> <?= $restaurant['status'] ? 'Open' : 'Closed'; ?></p>

				<?php if ($restaurant['status'] == 1): ?>
					<a href="/customer/menu/<?= $restaurant['id']; ?>" class="view-menu-button">View Menu</a>
				<?php else: ?>
					<button class="view-menu-button" disabled>Restaurant is currently closed</button>
				<?php endif; ?>

				<button class="heart-button <?= in_array($restaurant['id'], $favoriteIds) ? 'favorited' : '' ?>"
					data-id="<?= $restaurant['id'] ?>">♥</button>
			</div>
		<?php endforeach; ?>
	</div>


	<!-- Settings and Logout -->
	<div class="settings-logout-container">
		<div class="settings-button" id="settingsButton">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
					d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
			</svg>

			<div class="settings-dropdown">
				<a href="/customer/editprofile" class="settings-dropdown-item">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
					</svg>
					Profile Settings
				</a>

				<a href="javascript:void(0);" class="settings-dropdown-item" id="distance-preferences-toggle">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
    Distance Preferences
</a>

<!-- Range Slider - Hidden by default -->
<div class="range-slider" id="range-slider-container" style="display: none;">
    <input type="range" min="1" max="20" value="1" class="range-slider__range" id="range-slider">
    <span class="range-slider__value" id="range-value">1 km</span>
</div>

<script>
    // Select DOM elements
    const rangeSliderToggle = document.getElementById('distance-preferences-toggle');
    const rangeSliderContainer = document.getElementById('range-slider-container');
    const rangeSlider = document.getElementById('range-slider');
    const distanceValue = document.getElementById('range-value');

    // Toggle visibility of the range slider
    rangeSliderToggle.addEventListener('click', function () {
        if (rangeSliderContainer.style.display === 'none' || rangeSliderContainer.style.display === '') {
            rangeSliderContainer.style.display = 'block'; // Show the range slider
        } else {
            rangeSliderContainer.style.display = 'none'; // Hide the range slider
        }
    });

    // Update slider value and save it in localStorage
    rangeSlider.addEventListener('input', function () {
        const sliderValue = rangeSlider.value;
        localStorage.setItem('sliderValue', sliderValue);
        distanceValue.textContent = sliderValue + ' km';
    });

    // Load saved slider value from localStorage on page load
    window.onload = function () {
        const savedValue = localStorage.getItem('sliderValue');
        if (savedValue !== null) {
            rangeSlider.value = savedValue;
            distanceValue.textContent = savedValue + ' km';
        }
    };
</script>

			</div>

		</div>

		<form action="/customer/logout" method="get">
			<button type="submit" class="logout-button">Logout</button>
		</form>
	</div>
	<div class="settings-dropdown-overlay" id="settingsDropdownOverlay"></div>
</div>


<script>
	document.addEventListener('DOMContentLoaded', () => {
		const rangeSlider = document.getElementById('range-slider');
		const rangeValue = document.getElementById('range-value');
		let customerLatitude, customerLongitude;

		// Get user location
		function getUserLocation() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(
					(position) => {
						customerLatitude = position.coords.latitude;
						customerLongitude = position.coords.longitude;

						console.log("Customer Latitude:", customerLatitude);
						console.log("Customer Longitude:", customerLongitude);

						localStorage.setItem("userLatitude", customerLatitude);
						localStorage.setItem("userLongitude", customerLongitude);

						updateRestaurantList(customerLatitude, customerLongitude, rangeSlider.value);
						filterRestaurantsByLocation(rangeSlider.value);

						rangeSlider.addEventListener('input', () => {
							const range = rangeSlider.value;
							rangeValue.textContent = `${range} km`;
							updateRestaurantList(customerLatitude, customerLongitude, range);
							filterRestaurantsByLocation(range);
						});
					},
					(error) => {
						console.error('Error getting customer location:', error.message);
					}
				);
			} else {
				console.warn('Geolocation is not supported by this browser.');
			}
		}

		// Update restaurant list by range
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

		// Filter restaurants by range
		function filterRestaurantsByLocation(rangeValue) {
			const userLatitude = customerLatitude;
			const userLongitude = customerLongitude;

			if (userLatitude && userLongitude) {
				document.querySelectorAll('.restaurant-card').forEach((card) => {
					const lat = parseFloat(card.getAttribute('data-lat'));
					const lng = parseFloat(card.getAttribute('data-lng'));
					const distance = calculateDistance(userLatitude, userLongitude, lat, lng);

					if (distance <= rangeValue) {
						card.style.display = 'block';
					} else {
						card.style.display = 'none';
					}

					const distanceElement = card.querySelector('.restaurant-distance');
					if (distanceElement) {
						distanceElement.innerText = `${distance.toFixed(2)} km`;
					}
				});
			} else {
				console.warn('User location is not available.');
			}
		}

		// Calculate distance between two coordinates
		function calculateDistance(lat1, lon1, lat2, lon2) {
			const R = 6371; // Earth's radius in km
			const dLat = ((lat2 - lat1) * Math.PI) / 180;
			const dLon = ((lon2 - lon1) * Math.PI) / 180;
			const a =
				Math.sin(dLat / 2) * Math.sin(dLat / 2) +
				Math.cos((lat1 * Math.PI) / 180) *
				Math.cos((lat2 * Math.PI) / 180) *
				Math.sin(dLon / 2) *
				Math.sin(dLon / 2);
			const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
			return R * c;
		}

		// Favorite Handler
		function favoriteHandler(event) {
			event.preventDefault();

			const button = event.currentTarget;
			const restaurantId = button.dataset.id;

			toggleFavorite(button, restaurantId);
		}

		async function toggleFavorite(button, restaurantId) {
			try {
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
				button.disabled = false;
			}
		}

		function attachFavoriteListeners() {
			document.querySelectorAll('.heart-button').forEach(button => {
				button.removeEventListener('click', favoriteHandler);
				button.addEventListener('click', favoriteHandler);
			});
		}

		attachFavoriteListeners();

		// Settings Dropdown
		const settingsButton = document.getElementById('settingsButton');
		const settingsDropdownOverlay = document.getElementById('settingsDropdownOverlay');

		settingsButton.addEventListener('click', (e) => {
			e.stopPropagation();
			settingsButton.classList.toggle('active');
		});

		settingsDropdownOverlay.addEventListener('click', () => {
			settingsButton.classList.remove('active');
		});

		// Get User Location on Load
		getUserLocation();
	});
</script>


</body>

</html>