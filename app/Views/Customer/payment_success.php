<!DOCTYPE html>
<html>
<head>
    <title>Payment Status</title>
</head>
<body>
    <h1>Payment <?= esc($status) === 'PAID' ? 'Successful' : 'Status: ' . esc($status) ?></h1>
    <p>Order ID: <?= esc($order_id) ?></p>

    <?php if ($status !== 'PAID'): ?>
        <p>Please contact support if your payment failed.</p>
    <?php endif; ?>
</body>
</html>
