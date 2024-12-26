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
padding-bottom: 80px;
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
.navbar-logo img {
width: 120px;
height: auto;
border-radius: 8px;
cursor: pointer;
transition: transform 0.2s ease, box-shadow 0.2s ease;
}




</style>
</head>
<body>

<nav class="navbar">
<ul>
<!-- Navbar Logo -->
<li class="navbar-logo">
<a href="/customer/dashboard">
<img src="<?= base_url('/logo/dashboard-icon.png'); ?>"
alt="Dashboard"
class="navbar-logo-image">
</a>
</li>

<!-- Navigation Buttons -->
<li><button onclick="filterItems('All')" class="active">All</button></li>
<li><button onclick="filterItems('Beverages')">Beverages</button></li>
<li><button onclick="filterItems('Starter')">Starter</button></li>
<li><button onclick="filterItems('Main Course')">Main Course</button></li>
<li><button onclick="filterItems('Dessert')">Dessert</button></li>
</ul>
</nav>


<div class="menu-container">
<button onclick="window.history.back()" class="back-button"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
</svg>
Back</button>
<h2 id="category-title">All Menu Items</h2>
<div class="menu-items" id="menu-items-container">
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
const cartData = JSON.stringify(cart);

fetch('<?= base_url('customer/checkout') ?>', {
method: 'POST',
headers: {
'Content-Type': 'application/json'
},
body: cartData
})
.then(response => response.json())


.then(data => {
if (data.success) {
window.location.href = '<?= base_url('customer/checkout') ?>';
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

<?php foreach ($menuItems as $item): ?>
menuItems['<?= esc($item['type']) ?>'].push({
id: '<?= esc($item['id']) ?>',
name: '<?= esc($item['name']) ?>',
type: '<?= esc($item['type']) ?>',
price: <?= esc($item['price']) ?>,
photos: <?= json_encode(array_map(function($photo) {
return base_url($photo); // Add base_url to each photo path
}, json_decode($item['photos'], true))) ?>,
quantity_limit: <?= esc($item['quantity_limit']) ?>
});
<?php endforeach; ?>

const cart = {};

function updateQuantity(itemId, increment) {

const item = Object.values(menuItems)
.flat()
.find(item => item.id === itemId);

if (!item) return;

if (!cart[itemId]) {
cart[itemId] = { ...item, quantity: 0 };
}


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

document.querySelectorAll('.navbar button').forEach(btn => {
btn.classList.remove('active');
if (btn.textContent === category) {
btn.classList.add('active');
}
});


document.getElementById('category-title').textContent = category === 'All' ? 'All Menu Items' : category;


let itemsToDisplay = [];
if (category === 'All') {
Object.values(menuItems).forEach(categoryItems => {
itemsToDisplay = itemsToDisplay.concat(categoryItems);
});
} else {
itemsToDisplay = menuItems[category] || [];
}


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
<div class="slideshow-container">
${item.photos.map((photo, index) => `
<div class="mySlides fade" data-item="${item.id}">
<img src="${photo}" alt="${item.name}" class="menu-item-image">
</div>
`).join('')}
${item.photos.length > 1 ? `

<div class="dots">
${item.photos.map((_, index) => `
<span class="dot" onclick="currentSlide('${item.id}', ${index + 1})"></span>
`).join('')}
</div>
` : ''}
</div>
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
let slideIndex = {};

function showSlides(itemId) {
let slides = document.querySelectorAll(`.mySlides[data-item="${itemId}"]`);
let dots = document.querySelectorAll(`[data-item="${itemId}"] ~ .dots .dot`);

if (!slideIndex[itemId]) {
slideIndex[itemId] = 1;
}

// Hide all slides
slides.forEach(slide => slide.style.display = "none");

// Remove active class from dots
dots.forEach(dot => dot.classList.remove("active"));

// Show current slide
slides[slideIndex[itemId] - 1].style.display = "block";

// Highlight current dot
if (dots.length > 0) {
dots[slideIndex[itemId] - 1].classList.add("active");
}
}

function changeSlide(itemId, n) {
let slides = document.querySelectorAll(`.mySlides[data-item="${itemId}"]`);

slideIndex[itemId] = slideIndex[itemId] + n;

if (slideIndex[itemId] > slides.length) {
slideIndex[itemId] = 1;
}
if (slideIndex[itemId] < 1) {
slideIndex[itemId] = slides.length;
}

showSlides(itemId);
}

function currentSlide(itemId, n) {
slideIndex[itemId] = n;
showSlides(itemId);
}


itemsToDisplay.forEach(item => {
if (item.photos.length > 0) {
showSlides(item.id);
// Auto advance slides every 5 seconds
setInterval(() => changeSlide(item.id, 1), 5000);
}
});
}
}


filterItems('All');


</script>
</body>
</html>