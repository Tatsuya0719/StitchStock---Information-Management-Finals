<?php 
include('includes/header.php'); 
// Fetch revenue using existing logic
$revenue = $pdo->query("SELECT SUM(total) FROM Sales")->fetchColumn() ?: 0;

// Fetch Top Seller for the "Bespoke" feel
$best_seller = $pdo->query("
    SELECT p.prod_name, COUNT(s.prod_id) as times_sold 
    FROM Sales s 
    JOIN Products p ON s.prod_id = p.prod_id 
    GROUP BY s.prod_id 
    ORDER BY times_sold DESC 
    LIMIT 1
")->fetch();
?>

<div class="current-overview" style="margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
    <p style="text-transform: uppercase; font-size: 0.7rem; color: #999; letter-spacing: 2px; margin-bottom: 10px;">Business Intelligence</p>
    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin: 0; font-weight: 700;">The Ledger Balance</h1>
        <p style="color: #888; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px;">Fiscal Year 20XX</p>
    </div>
</div>

<div class="grid-container" style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px;">
    <div class="card" style="background: #121417; color: white; padding: 60px; border-radius: 0; position: relative; overflow: hidden;">
        <p style="text-transform: uppercase; font-size: 0.7rem; color: #666; letter-spacing: 2px;">Total Profit</p>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 4rem; margin: 20px 0; font-weight: 300;">$<?= number_format($revenue, 2) ?></h2>
        <div style="position: absolute; right: -20px; bottom: -20px; font-size: 10rem; opacity: 0.05; font-family: serif;">$</div>
    </div>

    <div class="card" style="background: white; border: 1px solid #eee; padding: 40px; border-radius: 0;">
        <p style="text-transform: uppercase; font-size: 0.7rem; color: #999; letter-spacing: 1.5px; margin-bottom: 20px;">Top Seller</p>
        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 10px;">
            <?= $best_seller ? htmlspecialchars($best_seller['prod_name']) : 'No Sales Recorded' ?>
        </h3>
        <?php if($best_seller): ?>
            <p style="font-size: 0.8rem; color: #c5a059; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">
                High-Value Asset
            </p>
        <?php endif; ?>
    </div>
</div>

<div class="card" style="margin-top: 40px; border: 1px solid #fee2e2; border-radius: 0; padding: 40px;">
    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.2rem; color: #991b1b; margin-bottom: 10px;">Database Management</h3>
    <p style="font-size: 0.85rem; color: #666; margin-bottom: 25px;">Perform a full system reset. Warning: This action is permanent and clears all Database entries.</p>
    
    <div style="display: flex; gap: 15px;">
        <form action="./maintenance_logic.php" method="POST" onsubmit="return confirm('WARNING: This will wipe all data. Proceed?');">
            <button type="submit" name="reset_system" 
                    style="background: #991b1b; color: white; border: none; padding: 12px 25px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; font-weight: 700;">
                Initialize Full Reset
            </button>
        </form>

        <a href="manage_categories.php" 
           style="background: #f1f5f9; color: #475569; text-decoration: none; padding: 12px 25px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">
            Manage Categories
        </a>
    </div>
</div>

<?php include('includes/footer.php'); ?>