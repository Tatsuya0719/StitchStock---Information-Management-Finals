<?php
include('includes/config.php');

if (isset($_POST['reset_system'])) {
    try {
        // We start a transaction to ensure either everything is deleted or nothing is
        $pdo->beginTransaction();

        // Step 1: Delete Sales first to avoid Foreign Key errors
        $pdo->exec("DELETE FROM Sales");
        
        // Step 2: Delete all Products
        $pdo->exec("DELETE FROM Products");
        
        // Step 3: Reset the ID counters so new items start at ID 1
        $pdo->exec("DELETE FROM sqlite_sequence WHERE name='Sales' OR name='Products'");

        $pdo->commit();

        $_SESSION['message'] = "System reset successful! All data cleared.";
        header("Location: index.php");
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Reset Failed: " . $e->getMessage());
    }
}