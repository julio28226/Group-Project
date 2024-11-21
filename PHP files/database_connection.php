<?php
// Connect to the database using PDO
function getDBConnection() {
    // Replace these with your actual database details
    $host = 'localhost';
    $dbname = 'group_project_database';
    $username = 'group_project';
    $password = '123456789';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}
?>