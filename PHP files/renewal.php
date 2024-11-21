<?php
// variables
$db_server = "localhost";
$db_user = "root";
$db_pass= "";
$db_name = "subscriptionproject";
$conn = "";
// Database connection
$conn =  mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Find subscriptions expiring in the next 7 days
$result = $conn->query("
    SELECT u.email, s.service_name, s.end_date 
    FROM subscriptions AS s
    JOIN users AS u ON s.user_id = u.user_id
    WHERE s.end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
      AND s.status = 'active'
");

while ($row = $result->fetch_assoc()) {
    $email = $row['email'];
    $service_name = $row['service_name'];
    $end_date = $row['end_date'];

    // Send reminder email (replace with your preferred email method)
    mail($email, "Subscription Renewal Reminder", 
         "Your subscription for $service_name will expire on $end_date. Please renew soon.");
}

echo "Renewal reminders sent!";
$conn->close();
?>
