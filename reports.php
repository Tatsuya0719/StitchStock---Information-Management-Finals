<?php 
include('includes/header.php'); 

// 1. Total Revenue (Using the 'total' column already in your file)
$revenue = $pdo->query("SELECT SUM(total) FROM Sales")->fetchColumn() ?: 0;

// 2. Top Selling Item
// We join with Products to get the name, ordering by the number of entries in Sales
$best_seller_query = $pdo->query("
    SELECT p.prod_name, COUNT(s.prod_id) as times_sold 
    FROM Sales s 
    JOIN Products p ON s.prod_id = p.prod_id 
    GROUP BY s.prod_id 
    ORDER BY times_sold DESC 
    LIMIT 1
");
$best_seller = $best_seller_query->fetch();

// 3. Recent Transactions
$recent_sales = $pdo->query("
    SELECT s.sale_date, p.prod_name, s.total 
    FROM Sales s 
    JOIN Products p ON s.prod_id = p.prod_id 
    ORDER BY s.sale_date DESC 
    LIMIT 5
")->fetchAll();
?>

<div class="header-flex">
    <h1>Business Intelligence</h1>
</div>

<div class="grid-3-col" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    <div class="card" style="background: var(--sidebar-bg); color: white;">
        <p>Total Revenue</p>
        <h2 style="font-size: 2rem;">$<?= number_format($revenue, 2) ?></h2>
    </div>
    
    <div class="card" style="border-left: 5px solid #6366f1;">
        <p style="color: #64748b; font-size: 0.8rem; text-transform: uppercase;">Top Seller</p>
        <h2 style="font-size: 1.2rem; margin-top: 5px;">
            <?= $best_seller ? htmlspecialchars($best_seller['prod_name']) : 'No Sales' ?>
        </h2>
    </div>

    <div class="card" style="border-left: 5px solid #f59e0b;">
        <p style="color: #64748b; font-size: 0.8rem; text-transform: uppercase;">Recent Activity</p>
        <h2 style="font-size: 1.8rem;"><?= count($recent_sales) ?> <small style="font-size: 0.9rem;">Sales</small></h2>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px;">
    <div class="card">
        <h3>Recent Sales Log</h3>
        <table class="inventory-table" style="margin-top: 15px; font-size: 0.85rem;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($recent_sales as $sale): ?>
                <tr>
                    <td><?= date('M d, H:i', strtotime($sale['sale_date'])) ?></td>
                    <td><strong><?= htmlspecialchars($sale['prod_name']) ?></strong></td>
                    <td>$<?= number_format($sale['total'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card" style="border-top: 4px solid var(--danger);">
        <h3 style="color: var(--danger);">System Maintenance</h3>
        <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 15px;">
            <a href="manage_categories.php" class="btn-primary" style="text-decoration:none; text-align:center;">
                Manage Categories
            </a>
            
            <form action="./maintenance_logic.php" method="POST" onsubmit="return confirm('WARNING: This will wipe all data. Proceed?');">
                <button type="submit" name="reset_system" class="btn-primary" style="background-color: var(--danger); width: 100%;">
                    Full System Reset
                </button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>