<?php
include('includes/config.php');

// We look for 'id' in the URL (GET method)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM Products WHERE prod_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $_SESSION['message'] = "Item successfully removed from inventory.";
    } catch (PDOException $e) {
        $_SESSION['message'] = "Error deleting item: " . $e->getMessage();
    }
}

// Always redirect back to the dashboard
header("Location: Inventory.php");
exit();
?>