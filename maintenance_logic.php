<?php
include('includes/config.php');

if (isset($_POST['reset_system'])) {
    try {
        // 1. Disable checks so we can wipe linked data
        $pdo->exec("PRAGMA foreign_keys = OFF;"); 

        // 2. Wipe all relevant tables
        $pdo->exec("DELETE FROM Sales;");
        $pdo->exec("DELETE FROM Products;");
        $pdo->exec("DELETE FROM Categories;"); // The missing piece

        // 3. Reset the auto-increment counters (Keep the IDs starting at 1)
        $pdo->exec("DELETE FROM sqlite_sequence WHERE name='Sales';");
        $pdo->exec("DELETE FROM sqlite_sequence WHERE name='Products';");
        $pdo->exec("DELETE FROM sqlite_sequence WHERE name='Categories';");

        $pdo->exec("PRAGMA foreign_keys = ON;");

        $_SESSION['message'] = "System Reconciled: All registries and collections cleared.";
        header("Location: reports.php");
        exit();
    } catch (PDOException $e) {
        die("Reset Failed: " . $e->getMessage());
    }
}