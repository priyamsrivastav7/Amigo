<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Registration - Amigo</title>
    <link rel="stylesheet" href="/css/style.css">
    <script>
        // Function to get the user's geolocation
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Fill in the latitude and longitude fields with the user's geolocation data
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;
                }, function(error) {
                    alert("Error getting location: " + error.message);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // Automatically call getLocation when the page loads
        window.onload = function() {
            getLocation();
        };
    </script>
</head>
<body>
    <div class="register-container">
        <h2>Restaurant Registration</h2>

        <!-- Display error or success message if any -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="error-message">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="/restaurant/registerSubmit" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?> <!-- CSRF Protection -->

            <div class="form-group">
                <label for="name">Restaurant Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your restaurant name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your restaurant email" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" placeholder="Enter phone number" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" placeholder="Enter restaurant address" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Picture</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>

            <!-- Latitude and Longitude Input Fields (hidden fields for auto population) -->
            <div class="form-group" hidden>
                <label for="latitude">Latitude</label>
                <input type="text" name="latitude" id="latitude" placeholder="Latitude" readonly>
            </div>

            <div class="form-group" hidden>
                <label for="longitude">Longitude</label>
                <input type="text" name="longitude" id="longitude" placeholder="Longitude" readonly>
            </div>

            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="/restaurant/login">Login here</a></p>
        </div>
    </div>
</body>
</html>
