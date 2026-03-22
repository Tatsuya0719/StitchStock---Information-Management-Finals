<?php
include('includes/db_connect.php'); // Ensure this points to your database connection

if (isset($_GET['id'])) {
    $cat_id = $_GET['id'];

    try {
        // 1. Temporarily disable foreign keys to allow deletion of a 'parent' category
        $pdo->exec("PRAGMA foreign_keys = OFF;");

        // 2. Execute the deletion
        $stmt = $pdo->prepare("DELETE FROM Categories WHERE cat_id = ?");
        $stmt->execute([$cat_id]);

        // 3. Re-enable foreign keys
        $pdo->exec("PRAGMA foreign_keys = ON;");

        header("Location: manage_categories.php?status=deleted");
        exit();
    } catch (PDOException $e) {
        die("Error: Could not clear category. " . $e->getMessage());
    }
} else {
    header("Location: manage_categories.php");
    exit();
}