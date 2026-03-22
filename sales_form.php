<?php 
include('includes/header.php'); 
$products = $pdo->query("SELECT * FROM Products WHERE stock_qty > 0")->fetchAll();
?>

<div class="header-flex">
    <h1>Process New Sale</h1>
</div>

<div class="card" style="max-width: 600px;">
    <form action="process_sale.php" method="POST">
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label>Select Item</label>
            <select name="prod_id" required style="width:100%; padding:10px; border-radius:5px;">
                <?php foreach($products as $p): ?>
                    <option value="<?= $p['prod_id'] ?>"><?= $p['prod_name'] ?> ($<?= $p['unit_price'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label>Quantity</label>
            <input type="number" name="qty_sold" min="1" required style="width:100%; padding:10px;">
        </div>
        <button type="submit" name="complete_sale" class="btn-primary">Confirm Sale</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>