<?php 
include('includes/header.php'); 

// 1. Fetch General Stats
$total_items = $pdo->query("SELECT SUM(stock_qty) FROM Products")->fetchColumn() ?: 0;
$low_stock_count = $pdo->query("SELECT COUNT(*) FROM Products WHERE stock_qty < 10")->fetchColumn();
$out_of_stock_count = $pdo->query("SELECT COUNT(*) FROM Products WHERE stock_qty = 0")->fetchColumn();
$total_skus = $pdo->query("SELECT COUNT(*) FROM Products")->fetchColumn() ?: 1;

// 2. Risk Calculations
$risk_percentage = round(($low_stock_count / $total_skus) * 100);
$depletion_percentage = round(($out_of_stock_count / $total_skus) * 100);

// 3. Movement Velocity
$monthly_sales = $pdo->query("SELECT SUM(qty_sold) FROM Sales WHERE sale_date >= date('now', '-30 days')")->fetchColumn() ?: 0;
$total_ever = $total_items + $monthly_sales;
$velocity_rate = ($total_ever > 0) ? round(($monthly_sales / $total_ever) * 100) : 0;

// 4. Data Fetching
$low_stock_items = $pdo->query("SELECT p.prod_id, p.prod_name, p.stock_qty, c.cat_name 
                    FROM Products p 
                    JOIN Categories c ON p.cat_id = c.cat_id 
                    WHERE p.stock_qty < 10 
                    ORDER BY p.stock_qty ASC")->fetchAll();

$recent_activity = $pdo->query("
    SELECT s.qty_sold, s.total, p.prod_name, s.sale_date 
    FROM Sales s 
    JOIN Products p ON s.prod_id = p.prod_id 
    ORDER BY s.sale_id DESC 
    LIMIT 4
")->fetchAll();
?>

<div style="margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
    <p style="text-transform: uppercase; font-size: 0.65rem; color: #999; letter-spacing: 2px; margin-bottom: 10px;">Current Overview</p>
    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 2.8rem; margin: 0; font-weight: 700;">The Ledger Balance</h1>
        <p style="color: #888; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px;"><?php echo date('l, F jS Y'); ?></p>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 50px;">
    <div class="card" style="padding: 30px; border: 1px solid #eee; background: #fff;">
        <p style="text-transform: uppercase; font-size: 0.6rem; color: #888; letter-spacing: 1.5px; margin:0;">Item Count</p>
        <div style="display: flex; align-items: baseline; gap: 8px; margin: 15px 0;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin: 0;"><?= number_format($total_items) ?></h2>
            <span style="color: #10b981; font-size: 0.75rem; font-weight: 700;">+<?= $velocity_rate ?>%</span>
        </div>
        <div style="width: 100%; height: 2px; background: #f0f0f0;">
            <div style="width: <?= $velocity_rate ?>%; height: 100%; background: #121417;"></div>
        </div>
    </div>

    <div class="card" style="padding: 30px; border: 1px solid #eee; background: #fff;">
        <p style="text-transform: uppercase; font-size: 0.6rem; color: #888; letter-spacing: 1.5px; margin:0;">Low Stock Items</p>
        <div style="display: flex; align-items: baseline; gap: 8px; margin: 15px 0;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin: 0; color: <?= ($low_stock_count > 0) ? '#c5a059' : '#121417' ?>;"><?= $low_stock_count ?></h2>
            <span style="color: #c5a059; font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">Urgent (<?= $risk_percentage ?>%)</span>
        </div>
        <div style="width: 100%; height: 2px; background: #f0f0f0;">
            <div style="width: <?= $risk_percentage ?>%; height: 100%; background: #c5a059;"></div>
        </div>
    </div>

    <div class="card" style="padding: 30px; border: 1px solid #eee; background: #fff;">
        <p style="text-transform: uppercase; font-size: 0.6rem; color: #888; letter-spacing: 1.5px; margin:0;">Depleted Items</p>
        <div style="display: flex; align-items: baseline; gap: 8px; margin: 15px 0;">
            <h2 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin: 0; color: <?= ($out_of_stock_count > 0) ? '#991b1b' : '#121417' ?>;"><?= $out_of_stock_count ?></h2>
            <span style="color: #991b1b; font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">Critical (<?= $depletion_percentage ?>%)</span>
        </div>
        <div style="width: 100%; height: 2px; background: #f0f0f0;">
            <div style="width: <?= $depletion_percentage ?>%; height: 100%; background: #991b1b;"></div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 50px; align-items: start;">
    
    <div>
        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.4rem; margin-bottom: 25px;">Critical Items</h3>
        <?php if ($low_stock_count > 0): ?>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                <?php foreach($low_stock_items as $item): ?>
                    <div style="background: white; border: 1px solid #eee; display: flex; align-items: center; padding: 20px;">
                        <div style="flex-grow: 1;">
                            <p style="font-weight: 700; margin: 0; font-size: 0.95rem;"><?= htmlspecialchars($item['prod_name']) ?></p>
                            <p style="font-size: 0.65rem; text-transform: uppercase; color: #999; letter-spacing: 1px; margin-top: 4px;"><?= htmlspecialchars($item['cat_name']) ?></p>
                        </div>
                        <div style="text-align: right; margin-right: 30px;">
                            <span style="font-size: 0.7rem; font-weight: 800; color: <?= ($item['stock_qty'] == 0) ? '#991b1b' : '#c5a059' ?>;">
                                <?= $item['stock_qty'] ?> Units
                            </span>
                        </div>
                        <a href="edit_form.php?id=<?= $item['prod_id']; ?>" style="text-decoration: none; font-size: 0.6rem; color: #121417; font-weight: 800; border: 1px solid #121417; padding: 8px 14px; text-transform: uppercase; letter-spacing: 1px;">Restock</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="padding: 60px; text-align: center; border: 1px solid #eee; background: #fff;">
                <p style="font-size: 0.75rem; color: #999; letter-spacing: 1px; text-transform: uppercase;">Inventory is Stable.</p>
            </div>
        <?php endif; ?>
    </div>

    <div style="border-left: 1px solid #eee; padding-left: 30px;">
        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.4rem; margin-bottom: 25px;">Recent Activity</h3>
        <div style="position: relative;">
            <?php foreach($recent_activity as $activity): ?>
                <div style="position: relative; margin-bottom: 30px; padding-left: 20px; border-left: 2px solid #121417;">
                    <p style="font-size: 0.55rem; text-transform: uppercase; color: #c5a059; font-weight: 800; letter-spacing: 1px; margin-bottom: 5px;">
                        <?= date('H:i', strtotime($activity['sale_date'])) ?> • Sale
                    </p>
                    <p style="font-weight: 700; font-size: 0.9rem; margin: 0;"><?= htmlspecialchars($activity['prod_name']) ?></p>
                    <p style="font-size: 0.75rem; color: #888; margin-top: 3px;">Sold <?= $activity['qty_sold'] ?> @ $<?= number_format($activity['total'], 2) ?></p>
                </div>
            <?php endforeach; ?>
            
            <div style="padding-left: 20px; border-left: 2px solid #eee;">
                <p style="font-size: 0.55rem; text-transform: uppercase; color: #bbb; font-weight: 800; margin-bottom: 5px;"><?php echo date('H:i'); ?> • System</p>
                <p style="font-weight: 700; font-size: 0.9rem; color: #bbb; margin: 0;">Session Active</p>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>