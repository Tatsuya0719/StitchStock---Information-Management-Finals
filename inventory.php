<?php 
include('includes/header.php'); 
$stmt = $pdo->query("SELECT p.*, c.cat_name FROM Products p JOIN Categories c ON p.cat_id = c.cat_id");
?>

<div class="current-overview" style="margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
    <p style="text-transform: uppercase; font-size: 0.7rem; color: #999; letter-spacing: 2px; margin-bottom: 10px;">The Atelier</p>
    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin: 0; font-weight: 700;">Inventory List</h1>
        <a href="add_product_form.php" style="background: #121417; color: white; text-decoration: none; padding: 12px 25px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600;">+ New Item</a>
    </div>
</div>

<?php if(isset($_SESSION['message'])): ?>
    <div class="card" style="border-left: 4px solid #10b981; margin-bottom: 30px; font-size: 0.9rem; padding: 15px 25px;">
        <span style="color: #10b981; font-weight: 700;">Inventory Updated:</span> <?= $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<div class="card" style="padding: 0; border: 1px solid #eee;">
    <table class="inventory-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #fcfcfc; border-bottom: 1px solid #eee;">
                <th style="padding: 20px; text-align: left; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px; color: #888;">Item Name & SKU</th>
                <th style="padding: 20px; text-align: left; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px; color: #888;">Category</th>
                <th style="padding: 20px; text-align: left; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px; color: #888;">Stock Available</th>
                <th style="padding: 20px; text-align: left; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px; color: #888;">Unit Price</th>
                <th style="padding: 20px; text-align: right; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px; color: #888;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $stmt->fetch()): ?>
            <tr style="border-bottom: 1px solid #f5f5f5;">
                <td style="padding: 25px 20px;">
                    <strong style="display: block; font-size: 1rem; color: #121417;"><?= htmlspecialchars($row['prod_name']) ?></strong>
                    <span style="font-size: 0.65rem; color: #aaa; text-transform: uppercase; letter-spacing: 1px;">SKU: SS-20XX-<?= str_pad($row['prod_id'], 3, '0', STR_PAD_LEFT) ?></span>
                </td>
                <td style="padding: 25px 20px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #666;">
                    <?= htmlspecialchars($row['cat_name']) ?>
                </td>
                <td style="padding: 25px 20px;">
                    <?php 
                        $status_color = ($row['stock_qty'] < 10) ? '#c5a059' : '#10b981';
                        if($row['stock_qty'] == 0) $status_color = '#991b1b';
                    ?>
                    <div style="display: inline-flex; background: #fafafa; border: 1px solid #eee; padding: 5px 10px; align-items: center; gap: 8px;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: <?= $status_color ?>"></span>
                        <span style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                            <?= ($row['stock_qty'] == 0) ? 'Out of Stock' : $row['stock_qty'] . ' Units' ?>
                        </span>
                    </div>
                </td>
                <td style="padding: 25px 20px; font-weight: 700; font-size: 1.1rem; font-family: 'Playfair Display', serif;">
                    $<?= number_format($row['unit_price'], 2) ?>
                </td>
                <td style="padding: 25px 20px; text-align: right;">
                    <a href="edit_form.php?id=<?= $row['prod_id'] ?>" style="color: #121417; text-decoration: none; font-size: 0.8rem; margin-right: 15px;">Edit</a>
                    <a href="delete.php?id=<?= $row['prod_id'] ?>" style="color: #991b1b; text-decoration: none; font-size: 0.8rem;" onclick="return confirm('Delete this item?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>