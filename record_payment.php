<?php
//HTML Required
require 'database_connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subscriptionId = $_POST['subscription_id'];
    $amount = $_POST['amount'];

    try {
        $pdo = getDBConnection();

        $sql = "INSERT INTO payments (subscription_id, payment_date, amount, status) VALUES (:subscription_id, NOW(), :amount, 'completed')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':subscription_id' => $subscriptionId,
            ':amount' => $amount
        ]);

        echo "Payment recorded successfully!";
    } catch (Exception $e) {
        echo "Error recording payment: " . $e->getMessage();
    }
}
?>