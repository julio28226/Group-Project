
<?php
// establishing variables
$db_server = "localhost";
$db_user = "root";
$db_pass= "";
$db_name = "subscriptionproject";
$conn = ""; //$conn is the variable used to connect

// Database connection
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Sanitize user inputs
$username = $conn->real_escape_string($_POST['username']); //real_escape_string allows for the use of special characters in a MySQL query
$email = $conn->real_escape_string($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); //password hash is used to apply a hash to the string, which obfuscates it making the password much more secure
$service_name = $conn->real_escape_string($_POST['service_name']);
$duration = (int) $_POST['duration'];
$amount = (float) $_POST['amount'];

// Calculate subscription end date
$start_date = date('Y-m-d');
$end_date = date('Y-m-d', strtotime("+$duration months"));

// Check if the user exists
$user_check = $conn->query("SELECT user_id FROM users WHERE email='$email'");
if ($user_check->num_rows == 0) {
    // Insert new user
    $conn->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
    $user_id = $conn->insert_id;
} else {
    $user = $user_check->fetch_assoc();
    $user_id = $user['user_id'];
}

// Insert subscription
$conn->query("INSERT INTO subscriptions (user_id, service_name, start_date, end_date, status) 
                VALUES ('$user_id', '$service_name', '$start_date', '$end_date', 'active')");
$subscription_id = $conn->insert_id; //insert_id displays the ID of the last INSERT query

// Insert payment record
$conn->query("INSERT INTO payments (user_id, subscription_id, amount, status) 
                VALUES ('$user_id', '$subscription_id', '$amount', 'paid')");

 


   


echo "Subscription created successfully!". "<br>";
echo "See below your current subscriptions!". "<br>";
$conn->close();
?>
<?php
include('renewal.php');
?>
<?php
require('Fetch_subscriptions.php');
?>