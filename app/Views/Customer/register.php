<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - Amigo</title>
    <link rel="stylesheet" href="/css/style.css"> 
    <style>
        body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #ff6b6b, #ffd93d);
    position: relative;
    overflow: hidden;
}

body::before,
body::after {
    content: '';
    position: absolute;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    z-index: 0;
}

body::before {
    top: -100px;
    right: -100px;
}

body::after {
    bottom: -100px;
    left: -100px;
}

.register-container {
    background: rgba(255, 255, 255, 0.9);
    padding: 2rem 2rem;
    border-radius: 16px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1),
                0 5px 15px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 480px;
    position: relative;
    z-index: 1;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.register-container:hover {
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15),
                0 10px 20px rgba(0, 0, 0, 0.2);
}

h2 {
    font-family: 'Poppins', sans-serif;
    color: #2d3436;
    font-size: 1.8rem;
    text-align: center;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.form-group {
    margin-bottom: 1.5rem;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    color: #2d3436;
    font-size: 0.9rem;
    font-weight: 500;
}

input {
    width: 90%;
    padding: 0.9rem 1.2rem;
    border: 2px solid #e8e8e8;
    border-radius: 12px;
    font-size: 1rem;
    background: white;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input:focus {
    border-color: #ff6b6b;
    outline: none;
    box-shadow: 0 4px 10px rgba(255, 107, 107, 0.2);
}

button {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #ff6b6b, #ffd93d);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.3s ease;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(255, 107, 107, 0.3);
}

button:active {
    transform: translateY(1px);
}

.error-message {
    background: #fff5f5;
    color: #ff6b6b;
    padding: 0.9rem 1.2rem;
    border-radius: 12px;
    margin-bottom: 1rem;
    border: 1px solid #ffe3e3;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    animation: fadeIn 0.3s ease-in-out;
}

.error-message::before {
    content: '⚠️';
    font-size: 1.2rem;
}

.login-link {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.login-link p {
    color: #636e72;
    font-size: 0.9rem;
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

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 480px) {
    .register-container {
        padding: 1.5rem;
    }

    h2 {
        font-size: 1.5rem;
    }
}

    </style>
</head>
<body>
    <div class="register-container">
        <h2>Customer Registration</h2>

        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="error-message">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="/customer/registerSubmit" method="post">
            <?= csrf_field(); ?> 

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
