<?php
//HTML Required
require 'database_connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    try {
        $pdo = getDBConnection();

        $sql = "INSERT INTO subscriptions (user_id, start_date, end_date, status) VALUES (:user_id, :start_date, :end_date, 'active')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':start_date' => $startDate,
            ':end_date' => $endDate
        ]);

        echo "Subscription created successfully!";
    } catch (Exception $e) {
        echo "Error creating subscription: " . $e->getMessage();
    }
}
?>