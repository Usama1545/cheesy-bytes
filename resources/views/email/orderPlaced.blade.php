<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
<p>Dear {{ $customer_name }},</p>

<p>Thank you for ordering from <a href="https://thecheesybite.com">{{ $restaurant_name }}</a>! We’re excited to serve you our delicious {{ $item_category }}.</p>

<h3>Order Summary:</h3>
<ul>
    <li>📌 Order Number: {{ $order->order_number }}</li>
    <li>📌 Items Ordered: {{ $items_ordered }}
    <ul>
        @foreach ($items_ordered as $item)
            <li>{{ $item['item_name'] }} (x{{ $item['qty'] }}) - {{ $item['addons_total_price'] + $item['item_price'] }}</li>
        @endforeach
    </ul></li>
    <li>📌 Total Amount: {{ $order->grand_total }}</li>
    <li>📌 Delivery/Pickup Time: {{ $order->delivery_time }}</li>
</ul>

<h3>💥 Special Deal Just for You! 💥</h3>
<p>As a thank you, enjoy <strong>Discount Code: CHEESY10</strong> for 10% off your next order!</p>

<p>We’d love to hear your feedback! Leave us a review <a href="https://g.page/r/CeqyAGhiVOUDEBM/review">here</a> and let us know about your experience.</p>

<p>See you again soon! 🍕</p>

<p>Best Regards,</p>
<p>Cheesy Bite Team</p>

<p>📍 {{ $location }}</p>
<p>📞 {{ $phone_number }}</p>
<p>🌐 <a href="https://thecheesybite.com">https://thecheesybite.com</a></p>
</body>
</html>
