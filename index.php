<?php 
include('includes/header.php'); 

// 1. Fetch General Stats
$total_items = $pdo->query("SELECT COUNT(*) FROM Products")->fetchColumn();
$low_stock_count = $pdo->query("SELECT COUNT(*) FROM Products WHERE stock_qty < 10")->fetchColumn();
$out_of_stock_count = $pdo->query("SELECT COUNT(*) FROM Products WHERE stock_qty = 0")->fetchColumn();

// 2. Fetch the specific items that are low (Less than 10 units)
// Added p.prod_id to the SELECT so we can use it for the link!
$low_stock_query = "SELECT p.prod_id, p.prod_name, p.stock_qty, c.cat_name 
                    FROM Products p 
                    JOIN Categories c ON p.cat_id = c.cat_id 
                    WHERE p.stock_qty < 10 
                    ORDER BY p.stock_qty ASC";
$low_stock_items = $pdo->query($low_stock_query)->fetchAll();
?>

<div class="header-flex">
    <h1>Boutique Dashboard</h1>
    <p style="color: #64748b;"><?php echo date('l, F jS Y'); ?></p>
</div>

<div class="grid-3-col" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    
    <div class="card" style="border-top: 4px solid var(--accent-color);">
        <h3 style="font-size: 0.9rem; text-transform: uppercase; color: #64748b;">Total Apparel</h3>
        <div style="font-size: 2.5rem; font-weight: 800; margin: 10px 0;"><?= $total_items ?></div>
        <a href="Inventory.php" style="color: var(--accent-color); text-decoration: none; font-size: 0.85rem;">View Full Inventory &rarr;</a>
    </div>

    <div class="card" style="border-top: 4px solid var(--warning);">
        <h3 style="font-size: 0.9rem; text-transform: uppercase; color: #64748b;">Low Stock Items</h3>
        <div style="font-size: 2.5rem; font-weight: 800; margin: 10px 0; color: var(--warning);"><?= $low_stock_count ?></div>
        <p style="font-size: 0.85rem;">Items below 10 units.</p>
    </div>

    <div class="card" style="border-top: 4px solid var(--danger);">
        <h3 style="font-size: 0.9rem; text-transform: uppercase; color: #64748b;">Out of Stock</h3>
        <div style="font-size: 2.5rem; font-weight: 800; margin: 10px 0; color: var(--danger);"><?= $out_of_stock_count ?></div>
        <p style="font-size: 0.85rem;">Immediate restock required.</p>
    </div>
</div>

<div class="card">
    <div class="header-flex" style="margin-bottom: 1rem;">
        <h2 style="font-size: 1.2rem;">Restock Alerts</h2>
        <span class="badge bg-warning">Priority List</span>
    </div>

    <?php if ($low_stock_count > 0): ?>
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Current Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($low_stock_items as $item): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($item['prod_name']) ?></strong></td>
                    <td><?= htmlspecialchars($item['cat_name']) ?></td>
                    <td>
                        <span class="badge <?= ($item['stock_qty'] == 0) ? 'bg-danger' : 'bg-warning' ?>" 
                              style="<?= ($item['stock_qty'] == 0) ? 'background:#fee2e2; color:#991b1b;' : '' ?>">
                            <?= $item['stock_qty'] ?> Units Left
                        </span>
                    </td>
                    <td>
                        <a href="edit_form.php?id=<?= $item['prod_id']; ?>" class="btn-primary" style="font-size: 0.8rem; padding: 5px 10px; text-decoration: none;">Restock</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="padding: 20px; text-align: center; color: #94a3b8;">
            <p>✅ All stock levels are healthy. No restocks needed.</p>
        </div>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>