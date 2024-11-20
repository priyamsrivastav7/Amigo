<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Login - Amigo</title>
    <link rel="stylesheet" href="/css/style.css"> <!-- Include your CSS File Here -->
</head>
<body>
    <div class="login-container">
        <h2>Restaurant Login</h2>

        <!-- Display error or success message if any -->
        <?php if(session()->getFlashdata('error')): ?>
            <div class="error-message">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="/restaurant/loginSubmit" method="post">
            <?= csrf_field(); ?> <!-- CSRF Protection -->

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Enter your restaurant email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
            </div>
            <button type="submit">Login</button>
        </form>

        <div class="register-link">
            <p>Don't have an account? <a href="/restaurant/register">Register here</a></p>
        </div>
    </div>
</body>
</html>
