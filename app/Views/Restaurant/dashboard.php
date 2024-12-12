<!-- app/Views/restaurant/dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <!-- <link rel="stylesheet" href="/css/style.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        .dashboard-container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2, h3 {
            color: #444;
        }

        h2 {
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="file"] {
            border: none;
            font-size: 14px;
            margin-bottom: 10px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #f4f4f4;
            color: #333;
        }

        .menu-item-image {
            border-radius: 5px;
            object-fit: cover;
        }

        form.inline-form {
            display: inline-block;
        }

        .status-enabled {
            color: green;
            font-weight: bold;
        }

        .status-disabled {
            color: red;
            font-weight: bold;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .dashboard-container {
                width: 95%;
                padding: 10px;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Log Out Button -->
        <div style="text-align: right; margin-bottom: 20px;">
            <form action="<?= base_url('/restaurant/logout'); ?>" method="get" style="display: inline;">
                <button type="submit" style="background-color: red; color: white; padding: 10px 15px; border: none; cursor: pointer;">Log Out</button>
            </form>
        </div>
        <h2>Welcome, <?= session()->get('restaurant_name'); ?>!</h2>

        <h3>Restaurant Status</h3>
        <form action="<?= base_url('/restaurant/updateStatus') ?>" method="post">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="1" <?= $restaurant['status'] == 1 ? 'selected' : ''; ?>>Open</option>
                <option value="0" <?= $restaurant['status'] == 0 ? 'selected' : ''; ?>>Closed</option>
            </select>
            <button type="submit">Update Status</button>
        </form>


        <h3>Add New Menu Item</h3>
        <form action="<?= base_url('/restaurant/addMenuItem') ?>" method="post" enctype="multipart/form-data">
    <!-- Type Selection -->
    <label for="type">Select Type</label>
    <select name="type" id="type" required>
        <option value="" disabled selected>Select Type</option>
        <option value="Beverages">Beverages</option>
        <option value="Starter">Starter</option>
        <option value="Main Course">Main Course</option>
        <option value="Dessert">Dessert</option>
    </select>

    <!-- Name Input -->
    <label for="name">Menu Item Name</label>
    <input type="text" name="name" id="name" required>

    <!-- Price Input -->
    <label for="price">Price</label>
    <input type="number" name="price" id="price" step="0.01" required>

    <!-- Quantity Limit Input -->
    <label for="quantity_limit">Quantity Limit</label>
    <input type="number" name="quantity_limit" id="quantity_limit" required>

    <!-- Photo Input -->
    <label for="photo">Upload Photo</label>
    <input type="file" name="photo" id="photo" accept="image/*">

    <!-- Submit Button -->
    <button type="submit">Add Menu Item</button>
</form>




        <h3>Your Menu Items</h3>
<?php if (!empty($menu_items)): ?>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Type</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity Limit</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menu_items as $item): ?>
                <tr>
                    <td>
                        <img src="<?= base_url('/' . $item['photo']); ?>" alt="<?= $item['name']; ?>" class="menu-item-image" style="width: 100px; height: 100px;">
                    </td>
                    <td><?= esc($item['type']); ?></td>
                    <td><?= esc($item['name']); ?></td>
                    <td><?= esc($item['price']); ?></td>
                    <td>
                        <form action="<?= base_url('/restaurant/updateQuantity/' . $item['id']); ?>" method="post" style="display: inline;">
                            <input type="number" name="quantity_limit" value="<?= esc($item['quantity_limit']); ?>" min="1" required style="width: 60px;">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>
                        <?php if ($item['status'] === 'enabled'): ?>
                            <span style="color: green;">Enabled</span>
                        <?php else: ?>
                            <span style="color: red;">Disabled</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form action="<?= base_url('/restaurant/deleteMenuItem/' . $item['id']); ?>" method="post" style="display: inline;">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                        <form action="<?= base_url('/restaurant/toggleStatus/' . $item['id']); ?>" method="post" style="display: inline;">
                            <?php if ($item['status'] === 'enabled'): ?>
                                <button type="submit">Disable</button>
                            <?php else: ?>
                                <button type="submit">Enable</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No menu items found.</p>
<?php endif; ?>

    </div>
</body>
</html>
