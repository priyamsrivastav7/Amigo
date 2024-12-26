<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Dashboard</title>
    
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

        h2 {
            text-align: center;
        }

        h3 {
            color: #444;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
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

        @media screen and (max-width: 768px) {
            .dashboard-container {
                width: 95%;
                padding: 10px;
            }
        }
    </style>

</head>
<body>
    <div class="dashboard-container">
        <div style="text-align: right; margin-bottom: 20px;">
            <form action="<?= base_url('/restaurant/mainmenu'); ?>" method="get" style="display: inline;">
                <button type="submit">Menu</button>
            </form>
            <form action="<?= base_url('/restaurant/logout'); ?>" method="get" style="display: inline;">
                <button type="submit" style="background-color: red;">Log Out</button>
            </form>
        </div>

        <h2>Welcome, <?= session()->get('restaurant_name'); ?>!</h2>

        <h3>Restaurant Status</h3>
        <form>
            <label for="status">Status:</label>
            <select name="status" id="status" onchange="updateStatus(this.value)">
                <option value="1" <?= $restaurant['status'] == 1 ? 'selected' : ''; ?>>Open</option>
                <option value="0" <?= $restaurant['status'] == 0 ? 'selected' : ''; ?>>Closed</option>
            </select>
        </form>     
    </div>

    <script>
        function updateStatus(status) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= base_url('/restaurant/updateStatus') ?>", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            <?php if (csrf_token()): ?>
            xhr.setRequestHeader("X-CSRF-TOKEN", "<?= csrf_hash(); ?>");
            <?php endif; ?>

            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert("Status updated successfully!");
                } else {
                    alert("Failed to update status. Please try again.");
                }
            };

            xhr.send("status=" + status);
        }
    </script>
</body>
</html>
