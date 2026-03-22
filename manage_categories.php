<?php 
include('includes/header.php'); 

// Logic to add a new category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_cat'])) {
    $cat_name = $_POST['new_cat_name'];
    $stmt = $pdo->prepare("INSERT INTO Categories (cat_name) VALUES (?)");
    $stmt->execute([$cat_name]);
}

$cats = $pdo->query("SELECT * FROM Categories")->fetchAll();
?>

<div class="header-flex">
    <h1>Manage Categories</h1>
    <a href="reports.php" class="btn-secondary" style="text-decoration:none;">&larr; Back</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
    <div class="card">
        <h3>Add Category</h3>
        <form method="POST" style="margin-top:15px;">
            <input type="text" name="new_cat_name" placeholder="Category Name" required 
                   style="width:100%; padding:10px; margin-bottom:10px; border-radius:5px; border:1px solid #ddd;">
            <button type="submit" name="add_cat" class="btn-primary" style="width:100%;">Save</button>
        </form>
    </div>

    <div class="card">
        <h3>Existing Categories</h3>
        <table class="inventory-table">
            <thead>
                <tr><th>ID</th><th>Category Name</th></tr>
            </thead>
            <tbody>
                <?php foreach($cats as $c): ?>
                <tr>
                    <td><?= $c['cat_id'] ?></td>
                    <td><strong><?= htmlspecialchars($c['cat_name']) ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/footer.php'); ?>