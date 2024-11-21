<?php
require 'database_connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    try {
        $pdo = getDBConnection();

        $sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email
        ]);

        echo "User registered successfully!";
    } catch (Exception $e) {
        echo "Error registering user: " . $e->getMessage();
    }
}
?>