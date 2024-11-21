<?php
function getUserSubscription($userId) {

    $pdo = getDBConnection();
    
    $sql = "
        SELECT users.name, subscriptions.start_date, subscriptions.end_date, subscriptions.status 
        FROM users
        JOIN subscriptions ON users.user_id = subscriptions.user_id
        WHERE users.user_id = :user_id
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    
    $subscription = $stmt->fetch();
    
    return $subscription;
}
