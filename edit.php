<?php
include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $id    = $_POST['prod_id'];
    $name  = $_POST['prod_name'];
    $price = $_POST['unit_price'];
    $qty   = $_POST['stock_qty'];
    $cat   = $_POST['cat_id'];

    try {
        $sql = "UPDATE Products 
                SET prod_name = :name, unit_price = :price, stock_qty = :qty, cat_id = :cat 
                WHERE prod_id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name'  => $name,
            ':price' => $price,
            ':qty'   => $qty,
            ':cat'   => $cat,
            ':id'    => $id
        ]);

        $_SESSION['message'] = "Product updated successfully!";
        header("Location: Inventory.php");
        exit();

    } catch (PDOException $e) {
        die("Update failed: " . $e->getMessage());
    }
} else {
    header("Location: Inventory.php");
    exit();
}
?>