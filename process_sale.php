<?php
include('includes/config.php');

if (isset($_POST['complete_sale'])) {
    $prod_id = $_POST['prod_id'];
    $qty_sold = $_POST['qty_sold'];

    try {
        // 1. Get the current price of the item to calculate total
        $stmt = $pdo->prepare("SELECT unit_price, stock_qty FROM Products WHERE prod_id = :id");
        $stmt->execute([':id' => $prod_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($qty_sold > $product['stock_qty']) {
            $_SESSION['message'] = "Error: Not enough stock available!";
            header("Location: sales_form.php");
            exit();
        }

        $total_price = $product['unit_price'] * $qty_sold;

        // Start a Transaction (ensures both SQLs work or none work)
        $pdo->beginTransaction();

        // 2. Record the sale
        $sql1 = "INSERT INTO Sales (prod_id, qty_sold, total) VALUES (:pid, :qty, :total)";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([':pid' => $prod_id, ':qty' => $qty_sold, ':total' => $total_price]);

        // 3. Subtract from stock
        $sql2 = "UPDATE Products SET stock_qty = stock_qty - :qty WHERE prod_id = :pid";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([':qty' => $qty_sold, ':pid' => $prod_id]);

        $pdo->commit();
        $_SESSION['message'] = "Sale completed! $qty_sold item(s) sold.";
        header("Location: Inventory.php");

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Transaction Failed: " . $e->getMessage());
    }
}