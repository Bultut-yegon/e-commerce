<?php
    session_start();
    
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login_db";
    
    $conn = new mysqli($host, $username, $password, $dbname);
    
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.html');
        exit();
    }
    
    // Retrieve the orders from the database
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM orders WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    // Close the database connection
    $stmt->close();
    $conn->close();
    ?>

<html>

<head>
    <link rel="stylesheet" href="orders.css">
    <title>My Orders</title>
</head>

<body>

    <h1>MY ORDERS</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Pickup Location</th>
                <th>Drop-off Location</th>
                <th>Pick-up Date</th>
                <th>Service Provider</th>
                <th>Phone Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['order_id']) ?></td>
                <td><?= htmlspecialchars($order['pickup_location']) ?></td>
                <td><?= htmlspecialchars($order['dropoff_location']) ?></td>
                <td><?= htmlspecialchars($order['pick_up_date']) ?></td>
                <td><?= htmlspecialchars($order['service_provider']) ?></td>
                <td><?= htmlspecialchars($order['phone_number']) ?></td>
                <td>
                    <button class=" btn btn-success"><a
                            href="edit.php?id=<?= htmlspecialchars($order['order_id']) ?>">Edit</a></button>
                    <button class="btn btn-primary"><a
                            href="generate.php?id=<?= htmlspecialchars($order['order_id']) ?>">Generate</a></button>
                    <button class="btn btn-danger"><a href="delete.php?id=<?= htmlspecialchars($order['order_id']) ?>"
                            onclick="return confirm('Are you sure you want to delete this order?')">Delete</a></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="PlaceOrder.html">Place a new order</a>

</body>

</html>