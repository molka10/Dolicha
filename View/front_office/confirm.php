<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
    <script>
        function validateForm(event) {
            const orderId = document.getElementById('order-id').value;
            const cardNumber = document.getElementById('card-number').value;
            const expiry = document.getElementById('expiry').value;
            const cvv = document.getElementById('cvv').value;
            const cardHolder = document.getElementById('card-holder').value;

            let isValid = true;
            let errorMessage = '';

            if (!orderId || orderId.trim() === '') {
                isValid = false;
                errorMessage += 'Order ID is required.\n';
            }

            if (!/^[0-9]{16}$/.test(cardNumber)) {
                isValid = false;
                errorMessage += 'Card number must be 16 digits.\n';
            }

            if (!expiry) {
                isValid = false;
                errorMessage += 'Expiry date is required.\n';
            }

            if (!/^[0-9]{3}$/.test(cvv)) {
                isValid = false;
                errorMessage += 'CVV must be 3 digits.\n';
            }

            if (!cardHolder || cardHolder.trim() === '') {
                isValid = false;
                errorMessage += 'Card holder name is required.\n';
            }

            if (!isValid) {
                alert(errorMessage);
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <div class="payment-container">
        <h1>Payment for Your Order</h1>
        <form action="confirm_commande.php" method="POST" onsubmit="validateForm(event)">
            <?php
            // Include your database configuration
            require_once 'C:\xampp\htdocs\dolicha0.2\config.php';

            try {
                $stmt = $pdo->prepare("SELECT idpanier, total FROM panier WHERE status = 1 ORDER BY idpanier DESC LIMIT 1;");
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $orderId = $result ? $result['idpanier'] : '';
                $totalAmount = $result ? $result['total'] : '';
            } catch (PDOException $e) {
                die("Database query failed: " . $e->getMessage());
            }

                ?>
            <label for="order-id">Order ID:</label>
            <input type="text" id="order-id" name="order_id" value="<?php echo htmlspecialchars($orderId); ?>" readonly>

            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" value="<?php echo htmlspecialchars($totalAmount); ?>" readonly>
            <input type="hidden" id="original-amount" name="original_amount" value="<?php echo htmlspecialchars($totalAmount); ?>">

            <label for="coupon-code">Coupon Code:</label>
            <input type="text" id="coupon-code" name="coupon_code" placeholder="Enter coupon code">

            <button type="button" id="apply-coupon" style="background-color: #007bff;">Apply Coupon</button>

            <label for="card-number">Card Number:</label>
            <input type="text" id="card-number" name="card_number" maxlength="16" placeholder="Enter your card number">

            <label for="expiry">Expiry Date:</label>
            <input type="month" id="expiry" name="expiry_date">

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" placeholder="Enter CVV">

            <label for="card-holder">Card Holder Name:</label>
            <input type="text" id="card-holder" name="card_holder" placeholder="Enter card holder name">

            <button type="submit">Pay Now</button>
            <button type="button" onclick="window.location.href='indexp.php'" style="background-color: #dc3545;">Cancel</button>
        </form>
    </div>

    <script>
    document.getElementById('apply-coupon').addEventListener('click', function () {
    const couponCode = document.getElementById('coupon-code').value.trim();
    const amountField = document.getElementById('amount');
    const originalAmount = document.getElementById('original-amount').value;

    if (couponCode === '') {
        alert('Please enter a coupon code.');
        return;
    }

    fetch('validate_coupon.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ coupon_code: couponCode })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const discount = data.discount;
            const discountedAmount = originalAmount - (originalAmount * (discount / 100));
            amountField.value = discountedAmount.toFixed(2);
            alert(`Coupon applied successfully! ${discount}% discount.`);
        } else {
            alert(data.message || 'Invalid coupon code.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});

</script>



    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .payment-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px; /* Add margin for spacing between buttons */
        }
        button[type="submit"] {
            background-color: #28a745;
        }
        button[type="submit"]:hover {
            background-color: #218838;
        }
        button[type="button"] {
            background-color: #dc3545; /* Red color for cancel button */
        }
        button[type="button"]:hover {
            background-color: #c82333; /* Darker red on hover */
        }
    </style>
</body>
</html>
