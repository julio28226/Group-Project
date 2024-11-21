<?php
function cancelSubscription($subscriptionId) {
    $pdo = getDBConnection();
    
    try {
        $pdo->beginTransaction();

        $sql = "
            UPDATE subscriptions 
            SET status = 'cancelled' 
            WHERE subscription_id = :subscription_id
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['subscription_id' => $subscriptionId]);

        $pdo->commit();
        echo "Subscription cancelled successfully!";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Failed to cancel subscription: " . $e->getMessage();
    }
}
?>