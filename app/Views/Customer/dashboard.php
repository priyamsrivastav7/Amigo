<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
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
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?= session()->get('customer_name'); ?>!</h2>
        <h3>Explore Our Partner Restaurants</h3>

        <?php if(!empty($restaurants)): ?>
            <div class="restaurant-list">
                <?php foreach($restaurants as $restaurant): ?>
                    <div class="restaurant-item">
                        <img src="<?= base_url('/' . $restaurant['image']); ?>" alt="<?= $restaurant['name']; ?>" class="restaurant-image">
                        <h4><?= $restaurant['name']; ?></h4>
                        <p><strong>Email:</strong> <?= $restaurant['email']; ?></p>
                        <p><strong>Phone:</strong> <?= $restaurant['phone_number']; ?></p>
                        <p><strong>Address:</strong> <?= $restaurant['address']; ?></p>
                        <a href="/customer/menu/<?= $restaurant['id']; ?>" class="view-menu-button">View Menu</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>No restaurants available at the moment. Please check back later!</p>
                <p>🍽️</p>
            </div>
        <?php endif; ?>

        <div class="logout-container">
            <form action="/customer/logout" method="get">
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>