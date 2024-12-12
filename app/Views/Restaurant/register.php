<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Registration - Amigo</title>
    <script>
        
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;
                }, function(error) {
                    alert("Error getting location: " + error.message);
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        
        window.onload = function() {
            getLocation();
        };
        
    </script>
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #ff6b6b, #ffd93d);
    overflow: hidden; 
    position: relative;
}

body::before,
body::after {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    z-index: 0;
}

body::before {
    top: -120px;
    left: -120px;
}

body::after {
    bottom: -120px;
    right: -120px;
}

.register-container {
    background: rgba(255, 255, 255, 0.9);
    padding: 1.5rem; 
    border-radius: 16px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1), 
                0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    max-height: 95vh;
    overflow-y: auto; 
    z-index: 1;
    position: relative;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

h2 {
    text-align: center;
    margin-bottom: 1rem;
    color: #333;
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem; 
    font-weight: 600;
}

.form-group {
    margin-bottom: 1rem; 
}

label {
    display: block;
    margin-bottom: 0.5rem;
    color: #444;
    font-size: 0.9rem; 
    font-weight: 500;
}

input, textarea {
    width: 100%;
    padding: 0.7rem;
    border: 1.5px solid #ddd;
    border-radius: 8px;
    font-size: 0.95rem; 
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.7);
}

textarea {
    resize: none;
    height: 80px;
}

input:focus, textarea:focus {
    border-color: #ff6b6b;
    outline: none;
    box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
}

button {
    width: 100%;
    padding: 0.8rem; 
    background: linear-gradient(135deg, #ff6b6b, #ffd93d);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    text-transform: uppercase;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: 0.5s;
}

button:hover::before {
    left: 100%;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
}

.error-message {
    background: #fff4f4;
    color: #ff6b6b;
    padding: 0.8rem 1rem;
    border: 1px solid #ffe6e6;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
}

.error-message::before {
    content: '⚠️';
}

.login-link {
    text-align: center;
    margin-top: 1rem; 
}

.login-link p {
    color: #636e72;
    font-size: 0.85rem;
}

.login-link a {
    color: #ff6b6b;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.login-link a:hover {
    color: #ffd93d;
}

@media (max-width: 768px) {
    .register-container {
        padding: 1rem; 
        max-width: 90%; 
    }

    h2 {
        font-size: 1.5rem; 
    }

    button {
        font-size: 0.9rem;
    }
}

    </style>
</head>
<body>
    <div class="register-container">
        <h2>Restaurant Registration</h2>

        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="error-message">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="/restaurant/registerSubmit" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?> 

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
