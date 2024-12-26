<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
        }

        .menu-container {
            width: 90%;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 1200px;
        }

        h2, h3 {
            color: #4CAF50;
            text-align: center;
        }

        h3 {
            margin-top: 40px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="number"], select, input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }

        input[type="text"]:focus, input[type="number"]:focus, select:focus, input[type="file"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        table th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
        }

        .menu-item-image {
            border-radius: 8px;
            object-fit: cover;
            width: 100px;
            height: 100px;
        }

        .status-enabled {
            color: green;
            font-weight: bold;
        }

        .status-disabled {
            color: red;
            font-weight: bold;
        }

        .actions button {
            background-color: #f44336;
            margin-right: 10px;
        }

        .actions button:hover {
            background-color: #e41e1e;
        }

        .update-quantity button {
            background-color: #2196F3;
        }

        .update-quantity button:hover {
            background-color: #1976D2;
        }
        

        @media screen and (max-width: 768px) {
            .menu-container {
                width: 95%;
                padding: 15px;
            }

            table th, table td {
                font-size: 14px;
            }

            button {
                padding: 10px 15px;
            }

            .menu-item-image {
                width: 80px;
                height: 80px;
            }
        }
        .back-button {
            /* position: fixed; */
            top: 20px;
            left: 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    
    <div class="menu-container">
    
    <a href="dashboard" class="back-button">&larr; Back</a>
    <h3>Add New Menu Item</h3>
    <form action="<?= base_url('/restaurant/addMenuItem') ?>" method="post" enctype="multipart/form-data">
    <label for="type">Select Type</label>
    <select name="type" id="type" required>
        <option value="" disabled selected>Select Type</option>
        <option value="Beverages">Beverages</option>
        <option value="Starter">Starter</option>
        <option value="Main Course">Main Course</option>
        <option value="Dessert">Dessert</option>
    </select>

    <label for="name">Menu Item Name</label>
    <input type="text" name="name" id="name" required>

    <label for="price">Price</label>
    <input type="number" name="price" id="price" step="0.01" required>

    <label for="quantity_limit">Quantity Limit</label>
    <input type="number" name="quantity_limit" id="quantity_limit" required>

    <label for="photos">Upload Photos</label>
    <input type="file" name="photos[]" id="photos" accept="image/*" multiple>

    <button type="submit">Add Menu Item</button>
</form>
<h3>Your Menu Items</h3>
<?php if (!empty($menuItems)): ?>
    <table>
        <thead>
            <tr>
                <th>Images</th>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Quantity Limit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menuItems as $item): ?>
                <tr>
                    <td>
                        <?php
                        // Decode the JSON-encoded 'photos' field
                        $photos = json_decode($item['photos'], true);
                        ?>
                        <?php if (!empty($photos)): ?>
                            <div class="slideshow-container">
                                <?php foreach ($photos as $index => $photo): ?>
                                    <div class="mySlides fade" data-item="<?= $item['id'] ?>">
                                        <img src="<?= base_url($photo) ?>" alt="Menu Image" class="menu-item-image">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p>No images available</p>
                        <?php endif; ?>
                    </td>
                    <td><?= esc($item['name']) ?></td>
                    <td><?= esc($item['type']) ?></td>
                    <td><?= esc($item['price']) ?></td>
                    <td><?= esc($item['quantity_limit']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No menu items available.</p>
<?php endif; ?>

<!-- Slideshow Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const items = document.querySelectorAll('.slideshow-container');
        items.forEach((container) => {
            let slides = container.querySelectorAll('.mySlides');
            let slideIndex = 0;

            function showSlides() {
                slides.forEach((slide, index) => {
                    slide.style.display = index === slideIndex ? 'block' : 'none';
                });
                slideIndex = (slideIndex + 1) % slides.length;
            }

            if (slides.length > 0) {
                showSlides(); // Initial display
                setInterval(showSlides, 5000); // Change every 5 seconds
            }
        });
    });
</script>


</body>
</html>
