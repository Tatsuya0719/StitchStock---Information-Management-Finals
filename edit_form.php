<?php 
include('includes/header.php'); 

// 1. Get the product ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM Products WHERE prod_id = :id");
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Fetch categories for the dropdown
    $categories = $pdo->query("SELECT * FROM Categories")->fetchAll(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "<div class='card'>Product not found.</div>";
        include('includes/footer.php');
        exit();
    }
} else {
    header("Location: Inventory.php");
    exit();
}
?>

<div class="header-flex">
    <h1>Edit Apparel Item</h1>
    <a href="Inventory.php" class="btn-secondary" style="text-decoration: none; color: #64748b;">&larr; Back to Inventory</a>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <form action="edit.php" method="POST">
        <input type="hidden" name="prod_id" value="<?= $product['prod_id'] ?>">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Product Name</label>
                <input type="text" name="prod_name" value="<?= htmlspecialchars($product['prod_name']) ?>" 
                       style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px;" required>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Category</label>
                <select name="cat_id" style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px;" required>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['cat_id'] ?>" <?= ($c['cat_id'] == $product['cat_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['cat_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Unit Price ($)</label>
                <input type="number" name="unit_price" step="0.01" value="<?= $product['unit_price'] ?>" 
                       style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px;" required>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600;">Stock Quantity</label>
                <input type="number" name="stock_qty" value="<?= $product['stock_qty'] ?>" 
                       style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px;" required>
            </div>

        </div>

        <div class="form-actions" style="margin-top: 20px; border-top: 1px solid #f1f5f9; padding-top: 20px; text-align: right;">
            <button type="submit" name="update_product" class="btn-primary" style="padding: 12px 30px;">
                Save Changes
            </button>
        </div>
    </form>
</div>

<?php include('includes/footer.php');
?>