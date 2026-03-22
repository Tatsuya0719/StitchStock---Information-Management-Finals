<?php 
include('includes/header.php'); 

// --- LOGIC SECTION: This runs ONLY when the button is clicked ---
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

        // Redirect to Inventory with a success message
        $_SESSION['message'] = "Added: " . htmlspecialchars($name);
        echo "<script>window.location.href='Inventory.php';</script>";
        exit();
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Fetch categories for the dropdown
$categories = $pdo->query("SELECT * FROM Categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="header-flex">
    <h1>New Inventory Item</h1>
    <a href="Inventory.php" style="color: #64748b; text-decoration: none;">&larr; Back</a>
</div>

<?php if(isset($error)): ?>
    <div class="card" style="border-left: 5px solid var(--danger); color: var(--danger);"><?= $error ?></div>
<?php endif; ?>

<div class="card" style="max-width: 600px;">
    <form action="" method="POST">
        <div style="margin-bottom: 1rem;">
            <label style="display:block; margin-bottom: 5px; font-weight: 600;">Product Name</label>
            <input type="text" name="prod_name" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px;" required>
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="display:block; margin-bottom: 5px; font-weight: 600;">Category</label>
            <select name="cat_id" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px;" required>
                <?php foreach($categories as $c): ?>
                    <option value="<?= $c['cat_id'] ?>"><?= $c['cat_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 1.5rem;">
            <div style="flex: 1;">
                <label style="display:block; margin-bottom: 5px; font-weight: 600;">Price ($)</label>
                <input type="number" name="unit_price" step="0.01" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px;" required>
            </div>
            <div style="flex: 1;">
                <label style="display:block; margin-bottom: 5px; font-weight: 600;">Quantity</label>
                <input type="number" name="stock_qty" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px;" required>
            </div>
        </div>

        <button type="submit" name="save_item" class="btn-primary" style="width: 100%;">Add to Stock</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>