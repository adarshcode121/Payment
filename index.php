<!DOCTYPE html>
<html>
<head>
    <title>Razorpay Payment Gateway</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Pay with Razorpay</h2>
    <form id="payment-form">
        <label for="amount">Amount (INR):</label>
        <input type="number" id="amount" name="amount" required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required><br><br>

        <button type="button" id="pay-button">Pay with Razorpay</button>
    </form>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $('#pay-button').click(function (e) {
            var amount = $('#amount').val() * 100; // Convert to paisa
            var name = $('#name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();

            if (!amount || !name || !email || !phone) {
                alert('Please fill all the fields');
                return;
            }

            var options = {
                "key": "rzp_test_44kONeFWXachHi", // Replace with your Razorpay Key ID
                "amount": amount, // Amount in paisa
                "currency": "INR",
                "name": "Your Company Name",
                "description": "Payment for your purchase",
                "image": "https://your-logo-url.com/logo.png",
                "prefill": {
                    "name": name,
                    "email": email,
                    "contact": phone
                },
                "theme": {
                    "color": "#F37254"
                },
                "handler": function (response) {
                    // Handle the response after payment
                    $.ajax({
                        url: 'charge.php',
                        type: 'post',
                        data: {
                            razorpay_payment_id: response.razorpay_payment_id,
                            amount: amount,
                            name: name,
                            email: email,
                            phone: phone
                        },
                        success: function () {
                            alert('Payment successful!');
                        },
                        error: function () {
                            alert('Payment failed!');
                        }
                    });
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
        });
    </script>
</body>
</html>