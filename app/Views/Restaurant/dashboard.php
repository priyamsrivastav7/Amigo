<!-- app/Views/restaurant/dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="/css/style.css">
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
