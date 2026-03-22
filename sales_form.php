<?php 
include('includes/header.php'); 
$products = $pdo->query("SELECT * FROM Products WHERE stock_qty > 0")->fetchAll();
?>

<div class="current-overview" style="margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
    <p style="text-transform: uppercase; font-size: 0.7rem; color: #999; letter-spacing: 2px; margin-bottom: 10px;">Transaction Registry</p>
    <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin: 0; font-weight: 700;">New Sale Entry</h1>
</div>

<div class="card" style="max-width: 700px; margin: 0 auto; padding: 50px; border-radius: 0;">
    <form action="process_sale.php" method="POST">
        <div style="margin-bottom: 2.5rem;">
            <label style="display:block; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1.5px; color: #888; margin-bottom: 15px;">Select Clothing Item</label>
            <select name="prod_id" required style="width:100%; padding:15px; border: 1px solid #eee; background: #fff; font-size: 1rem;">
                <?php foreach($products as $p): ?>
                    <option value="<?= $p['prod_id'] ?>" data-stock="<?= $p['stock_qty'] ?>">
                        <?= htmlspecialchars($p['prod_name']) ?> (Available: <?= $p['stock_qty'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-bottom: 3rem;">
            <label style="display:block; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1.5px; color: #888; margin-bottom: 15px;">Quantity Sold</label>
            <input type="number" name="qty_sold" min="1" value="1" required style="width:100%; padding:15px; border: 1px solid #eee; font-size: 1rem;">
        </div>

        <button type="submit" name="complete_sale" style="background: #121417; color: white; border: none; padding: 20px; width: 100%; text-transform: uppercase; letter-spacing: 2px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">
            Finalize Transaction
        </button>
    </form>
</div>

<?php include('includes/footer.php'); ?>