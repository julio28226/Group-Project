<?php
// establishing variables
$db_server = "localhost";
$db_user = "root";
$db_pass= "";
$db_name = "subscriptionproject";
$conn = "";
// Database connection
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); //will show standard error message
}

// Fetch subscriptions and user data
$query = "       
    SELECT 
        u.username, 
        u.email, 
        s.service_name, 
        s.start_date, 
        s.end_date, 
        s.status, 
        p.amount, 
        p.payment_date, 
        p.status AS payment_status
    FROM subscriptions s
    JOIN users u ON s.user_id = u.user_id
    LEFT JOIN payments p ON s.subscription_id = p.subscription_id
    ORDER BY s.end_date DESC";  
    
    
$result = $conn->query($query);
//preparing a query

if (!$result) {
    die("Query failed: " . $conn->error);
}
//Joins are applied to the users and subscriptions tables to get data
//Left Joins on payment in order to display payment info for subscriptions if it exists.


// Store data in an array
$subscriptions = [];
while ($row = $result->fetch_assoc()) {
    $subscriptions[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    
    <title>Subscription Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<!-- creating an html table to give a visual display of the MySQL data-->
    <title>Subscription Data</title>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Service Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Subscription Status</th>
                <th>Number of Subscriptions</th>
                <th>Payment Date</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($subscriptions)): ?>
                <?php foreach ($subscriptions as $subscription): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($subscription['username']); ?></td>
                        <td><?php echo htmlspecialchars($subscription['email']); ?></td>
                        <td><?php echo htmlspecialchars($subscription['service_name']); ?></td>
                        <td><?php echo htmlspecialchars($subscription['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($subscription['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($subscription['status']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($subscription['amount'], 2)); ?></td>
                        <td><?php echo htmlspecialchars($subscription['payment_date']); ?></td>
                        <td><?php echo htmlspecialchars($subscription['payment_status']); ?></td>
                    </tr>
                <!-- using htmlspecialchars to sanitize inputs-->
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No subscriptions found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
