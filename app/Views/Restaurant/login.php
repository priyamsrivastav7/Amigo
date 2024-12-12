<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Login - Amigo</title>
    <!-- <link rel="stylesheet" href="/css/style.css"> Include your CSS File Here -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(45deg, 
                #ff6b6b, 
                #ffd93d);
            position: relative;
            overflow: hidden;
        }

        /* Decorative food-themed background elements */
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

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1),
                        0 8px 20px rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 450px;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .login-header::before {
            content: '👨‍🍳';
            font-size: 3rem;
            display: block;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }

        .temp {
    display: flex;
    align-items: center; /* Aligns items vertically */
    justify-content: center; /* Aligns items horizontally */
}

        h2 {
            font-family: 'Playfair Display', serif;
            color: #2d3436;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            text-transform: capitalize;
        }

        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 0.7rem;
            color: #2d3436;
            font-weight: 500;
            font-size: 0.95rem;
        }

        input {
            width: 100%;
            padding: 1rem 1.2rem;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        input:focus {
            border-color: #ff6b6b;
            outline: none;
            box-shadow: 0 0 0 4px rgba(255, 107, 107, 0.1);
        }

        button {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(45deg, #ff6b6b, #ffd93d);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
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
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transition: 0.5s;
        }

        button:hover::before {
            left: 100%;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
        }

        .register-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eee;
        }

        .register-link p {
            color: #636e72;
            font-size: 0.95rem;
        }

        .register-link a {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #ffd93d;
        }

        .error-message {
            background: #fff5f5;
            color: #ff6b6b;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid #ffe3e3;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message::before {
            content: '⚠️';
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Glass morphism effect on hover */
        .login-container:hover {
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15),
                        0 10px 25px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 2rem;
                margin: 1rem;
            }

            h2 {
                font-size: 1.8rem;
            }

            .login-header::before {
                font-size: 2.5rem;
            }
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="login-container">
        <div class="temp" ><h2>Restaurant Login</h2></div>
        
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
            <div class="g-recaptcha" data-sitekey="6LfIOokqAAAAAEQU9huijCZGbZdmzjnbluezRZb_"></div>
            <button type="submit">Login</button>
        </form>

        <div class="register-link">
            <p>Don't have an account? <a href="/restaurant/register">Register here</a></p>
        </div>
    </div>
</body>
</html>
