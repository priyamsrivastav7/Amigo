<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - Amigo</title>
    <link rel="stylesheet" href="/css/style.css"> <!-- Include your CSS File Here -->
</head>
<body>
    <div class="register-container">
        <h2>Customer Registration</h2>

        <!-- Display error or success message if any -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="error-message">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="/customer/registerSubmit" method="post">
            <?= csrf_field(); ?> <!-- CSRF Protection -->

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" placeholder="Enter your phone number" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="/customer/login">Login here</a></p>
        </div>
    </div>
</body>
</html>
