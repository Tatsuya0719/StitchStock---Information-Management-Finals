<?php 
include('includes/header.php'); 

// --- LOGIC SECTION ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_item'])) {
    $name  = $_POST['prod_name'];
    $cat   = $_POST['cat_id'];
    $price = $_POST['unit_price'];
    $qty   = $_POST['stock_qty'];

    try {
        $sql = "INSERT INTO Products (prod_name, cat_id, unit_price, stock_qty) 
                VALUES (:name, :cat, :price, :qty)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':name' => $name, ':cat' => $cat, ':price' => $price, ':qty' => $qty]);

        // SUCCESS: Redirect to the CORRECT lowercase filename
        $_SESSION['message'] = "Added: " . htmlspecialchars($name);
        echo "<script>window.location.href='inventory.php';</script>"; 
        exit();
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Fetch categories for the dropdown
$categories = $pdo->query("SELECT * FROM Categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="current-overview" style="margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
    <p style="text-transform: uppercase; font-size: 0.7rem; color: #999; letter-spacing: 2px; margin-bottom: 10px;">Inventory Management</p>
    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin: 0; font-weight: 700;">Update Inventory</h1>
        <a href="inventory.php" style="color: #888; text-decoration: none; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px;">&larr; Return to Inventory</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px;">
    <div class="card" style="padding: 40px; border-radius: 0;">
        <?php if(isset($error)): ?>
            <div style="margin-bottom: 20px; color: #991b1b; font-size: 0.8rem; border-left: 3px solid #991b1b; padding-left: 15px;"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div style="margin-bottom: 2rem;">
                <label style="display:block; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1.5px; color: #888; margin-bottom: 10px;">Item Name</label>
                <input type="text" name="prod_name" placeholder="e.g. Italian Merino Blazer" style="width:100%; padding:15px; border:none; border-bottom: 1px solid #eee; font-family: 'Playfair Display', serif; font-size: 1.5rem;" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 2rem;">
                <div>
                    <label style="display:block; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1.5px; color: #888; margin-bottom: 10px;">Category</label>
                    <select name="cat_id" style="width:100%; padding:12px; border: 1px solid #eee; font-size: 0.8rem; text-transform: uppercase;" required>
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c['cat_id'] ?>"><?= $c['cat_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label style="display:block; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1.5px; color: #888; margin-bottom: 10px;">Pricing ($)</label>
                    <input type="number" name="unit_price" step="0.01" style="width:100%; padding:12px; border: 1px solid #eee;" required>
                </div>
            </div>

            <div style="margin-bottom: 3rem;">
                <label style="display:block; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1.5px; color: #888; margin-bottom: 10px;">Initial Stock</label>
                <input type="number" name="stock_qty" style="width:100%; padding:12px; border: 1px solid #eee;" required>
            </div>

            <button type="submit" name="save_item" style="background: #121417; color: white; border: none; padding: 18px 40px; width: 100%; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; font-weight: 700; cursor: pointer;">
                Add to Inventory
            </button>
        </form>
    </div>

    <div style="background: #121417; color: white; padding: 40px; display: flex; flex-direction: column; justify-content: center;">
        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 20px; color: #c5a059;">Inventory Protocols</h3>
        <p style="font-size: 0.85rem; line-height: 1.6; opacity: 0.7; margin-bottom: 30px;">Ensure all inventory entries are accurate and up-to-date. All fields are required to be filled before adding the item to the inventory.</p>
        <ul style="list-style: none; padding: 0; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; display: flex; flex-direction: column; gap: 15px;">
            <li><span style="color: #c5a059;">&bull;</span> Verify Unique SKU IDs</li>
            <li><span style="color: #c5a059;">&bull;</span> Check Pricing Properly</li>
            <li><span style="color: #c5a059;">&bull;</span> Ensure Accurate Stock Quantities</li>
        </ul>
    </div>
</div>

<?php include('includes/footer.php'); ?>