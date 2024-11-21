<?php
function isSubscriptionValid($subscriptionId) {
    $pdo = getDBConnection();
    
    $sql = "
        SELECT end_date, status 
        FROM subscriptions 
        WHERE subscription_id = :subscription_id
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['subscription_id' => $subscriptionId]);
    
    $subscription = $stmt->fetch();
    
    if ($subscription && $subscription['status'] == 'active' && $subscription['end_date'] > date('Y-m-d')) {
        return true;
    }
    
    return false;
}
?>