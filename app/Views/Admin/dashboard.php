<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Restaurant Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 1rem;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            text-transform: uppercase;
        }

        .btn-approve {
            background-color: #28a745;
            color: white;
        }

        .btn-disapprove {
            background-color: #dc3545;
            color: white;
        }

        .btn-view {
            background-color: #007bff;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard - All Restaurants</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Restaurant Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($restaurants as $restaurant): ?>
                <tr>
                    <td><?= $restaurant['id']; ?></td>
                    <td><?= $restaurant['name']; ?></td>
                    <td><?= $restaurant['email']; ?></td>
                    <td>
                        <?= $restaurant['is_live'] ? 'Approved' : 'Pending Approval'; ?>
                    </td>
                    <td>
                        <a href="/admin/view/<?= $restaurant['id']; ?>" class="btn btn-view">View</a>
                        <?php if (!$restaurant['is_live']): ?>
                            <a href="/admin/approve/<?= $restaurant['id']; ?>" class="btn btn-approve">Approve</a>
                            <a href="/admin/disapprove/<?= $restaurant['id']; ?>" class="btn btn-disapprove">Disapprove</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
