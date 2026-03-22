<?php 
include('includes/header.php'); 

// Your logic to fetch products
$stmt = $pdo->query("SELECT p.*, c.cat_name FROM Products p JOIN Categories c ON p.cat_id = c.cat_id");
?>

<div class="header-flex">
    <h1>Apparel Inventory</h1>
    <a href="add_product_form.php" class="btn-primary">+ Add New Product</a>
</div>

<?php if(isset($_SESSION['message'])): ?>
    <div class="card" style="border-left: 5px solid var(--success); color: var(--success);">
        <?= $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<div class="card">
    <table class="inventory-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $stmt->fetch()): ?>
            <tr>
                <td><strong><?= $row['prod_name'] ?></strong></td>
                <td><span class="badge"><?= $row['cat_name'] ?></span></td>
                <td>$<?= number_format($row['unit_price'], 2) ?></td>
                <td>
                    <?php if($row['stock_qty'] < 10): ?>
                        <span class="badge bg-warning"><?= $row['stock_qty'] ?> Low</span>
                    <?php else: ?>
                        <span class="badge bg-success"><?= $row['stock_qty'] ?> In Stock</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit_form.php?id=<?= $row['prod_id'] ?>">Edit</a> | 
                    <a href="delete.php?id=<?= $row['prod_id'] ?>" style="color: var(--danger)">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>