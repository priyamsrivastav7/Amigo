<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashfree Checkout Integration</title>
    <!-- Load the v3 SDK -->
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
</head>
<body>
    <h2>Redirecting to Cashfree Payment...</h2>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cashfree = Cashfree({
                mode: "sandbox", // Use "production" when live
            });

            let checkoutOptions = {
                paymentSessionId: "<?= esc($session_id) ?>",
                redirectTarget: "_self" // Can be "_blank" for new tab
            };

            // Optional: Add a slight delay to ensure SDK is loaded
            setTimeout(() => {
                cashfree.checkout(checkoutOptions);
            }, 500);
        });
    </script>
</body>
</html>
