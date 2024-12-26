<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        /body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            padding: 2rem;
            color: #2d3436;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: #2d3436;
            text-align: center;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        form label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        form input {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #dcdde1;
            border-radius: 8px;
            font-size: 1rem;
        }

        form button {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
        }

        form button:hover {
            background: #e05656;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
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

        .feedback-message {
            text-align: center;
            color: #ff6b6b;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<button onclick="window.history.back()" class="back-button"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back</button>
    <h1>Edit Profile</h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <div>
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <p><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>

    <form action="<?= base_url('/customer/updateprofile') ?>" method="post">
        <?= csrf_field() ?>

        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?= esc($customer['name']) ?>" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= esc($customer['email']) ?>" required><br><br>

        <label for="phone_number">Phone Number:</label><br>
        <input type="text" id="phone_number" name="phone_number" value="<?= esc($customer['phone_number']) ?>" required><br><br>

        <label for="password">New Password (leave blank to keep current password):</label><br>
        <input type="password" id="password" name="password"><br><br>

        <button type="submit">Update Profile</button>
    </form>
</body>
</html>
