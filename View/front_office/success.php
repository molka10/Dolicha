<?php
session_start();
require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

// You can also pass the order ID and payment status from the previous page (using session or GET)
$orderId = isset($_GET['order_id']) ? $_GET['order_id'] : '';
$paymentStatus = isset($_GET['status']) ? $_GET['status'] : 'Success';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1, h3 {
            color: #333;
        }

        /* Payment Success Section */
        .payment-success {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin: 50px auto;
            padding: 30px;
            text-align: center;
        }

        .payment-success h1 {
            color: #4CAF50; /* Green for success */
            font-size: 36px;
            margin-bottom: 20px;
        }

        .payment-success p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .order-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .order-details h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .order-details ul {
            list-style-type: none;
            padding: 0;
            font-size: 18px;
        }

        .order-details li {
            margin-bottom: 10px;
        }

        .order-details li strong {
            color: #333;
        }

        /* Links and Actions */
        .actions {
            display: flex;
            justify-content: space-around;
        }

        .actions a {
            text-decoration: none;
            background-color: #4CAF50; /* Green */
            color: #fff;
            padding: 12px 24px;
            border-radius: 5px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .actions a:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .payment-success {
                width: 80%;
            }

            .actions {
                flex-direction: column;
                gap: 15px;
            }

            .actions a {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="payment-success">
        <h1>Payment Successful</h1>
        <p>Thank you for your payment. Your order has been processed.</p>

        <div class="order-details">
            <h3>Order Information:</h3>
            <ul>
                <li><strong>Order ID:</strong> <?php echo htmlspecialchars($orderId); ?></li>
                <li><strong>Status:</strong> <?php echo htmlspecialchars($paymentStatus); ?></li>
            </ul>
        </div>

        <p>If you have any questions, feel free to contact us.</p>

        <div class="actions">
            <a href="indexp.php">Go to Home</a>
            <a href="affichecommande.php">View My Orders</a>
        </div>
    </div>

</body>
</html>
