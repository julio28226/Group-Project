<?php
function renewSubscription($subscriptionId, $amount) {
    $pdo = getDBConnection();
    
    try {
        $pdo->beginTransaction();

        $sql = "
            UPDATE subscriptions 
            SET end_date = DATE_ADD(end_date, INTERVAL 1 MONTH) 
            WHERE subscription_id = :subscription_id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['subscription_id' => $subscriptionId]);

        $sql = "
            INSERT INTO payments (subscription_id, payment_date, amount) 
            VALUES (:subscription_id, NOW(), :amount)
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['subscription_id' => $subscriptionId, 'amount' => $amount]);

        $pdo->commit();
        echo "Subscription renewed successfully!";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Failed to renew subscription: " . $e->getMessage();
    }
}
?>