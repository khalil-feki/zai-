<?php
require_once 'app/config/config.php';
require_once 'app/config/database.php';
require_once 'app/models/User.php';

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Simple Registration Test</h1>";

// Create database connection
$db = new Database();
$conn = $db->getConnection();

// Test direct database insertion
echo "<h2>Testing Direct Database Insertion</h2>";

try {
    // Start transaction
    $conn->beginTransaction();
    
    // Test data
    $firstname = "Test";
    $lastname = "User";
    $email = "test" . time() . "@example.com";
    $companyName = "Test Company";
    
    // Insert into main table
    $query = "INSERT INTO h8pd_societe (nom, firstname, lastname, email, entity, datec, status) 
              VALUES (:nom, :firstname, :lastname, :email, 1, NOW(), 1)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nom', $companyName);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    
    echo "<p>Executing query: " . str_replace([':nom', ':firstname', ':lastname', ':email'], 
                                             [$companyName, $firstname, $lastname, $email], 
                                             $query) . "</p>";
    
    if ($stmt->execute()) {
        $userId = $conn->lastInsertId();
        echo "<p style='color:green'>User inserted into main table with ID: {$userId}</p>";
        
        // Insert into extrafields
        $password = "password123";
        $query = "INSERT INTO h8pd_societe_extrafields (fk_object, mot_de_passe) 
                  VALUES (:fk_object, :password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fk_object', $userId);
        $stmt->bindParam(':password', $password);
        
        echo "<p>Executing extrafields query: " . str_replace([':fk_object', ':password'], 
                                                            [$userId, $password], 
                                                            $query) . "</p>";
        
        if ($stmt->execute()) {
            echo "<p style='color:green'>Extrafields inserted successfully</p>";
            $conn->commit();
            echo "<p style='color:green'>Transaction committed successfully</p>";
        } else {
            throw new Exception("Failed to insert extrafields");
        }
    }
} catch (Exception $e) {
    $conn->rollBack();
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
