<?php 
include('includes/header.php'); 

// --- LOGIC SECTION ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_cat'])) {
    $cat_name = $_POST['cat_name'];
    $stmt = $pdo->prepare("INSERT INTO Categories (cat_name) VALUES (?)");
    $stmt->execute([$cat_name]);
    echo "<script>window.location.href='manage_categories.php';</script>";
    exit();
}

$categories = $pdo->query("SELECT * FROM Categories")->fetchAll();
?>

<div class="current-overview" style="margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 20px;">
    <p style="text-transform: uppercase; font-size: 0.7rem; color: #999; letter-spacing: 2px; margin-bottom: 10px;">Database Configuration</p>
    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin: 0; font-weight: 700;">Manage Categories</h1>
        <p style="color: #888; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 1px;">Inventory Classifications</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 40px;">
    
    <div>
        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 25px;">Active Categories</h3>
        
        <div class="card" style="padding: 0; border: 1px solid #eee;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #fcfcfc; border-bottom: 1px solid #eee;">
                        <th style="padding: 20px; text-align: left; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px; color: #888;">ID</th>
                        <th style="padding: 20px; text-align: left; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px; color: #888;">Collection Name</th>
                        <th style="padding: 20px; text-align: right; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1px; color: #888;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($categories as $cat): ?>
                    <tr style="border-bottom: 1px solid #f5f5f5;">
                        <td style="padding: 20px; font-size: 0.8rem; color: #aaa;">#<?= str_pad($cat['cat_id'], 2, '0', STR_PAD_LEFT) ?></td>
                        <td style="padding: 20px;">
                            <strong style="font-size: 1rem; color: #121417; letter-spacing: 0.5px;"><?= htmlspecialchars($cat['cat_name']) ?></strong>
                        </td>
                        <td style="padding: 20px; text-align: right;">
                            <a href="delete_category.php?id=<?= $cat['cat_id'] ?>" 
                               style="color: #991b1b; text-decoration: none; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;"
                               onclick="return confirm('Note: Deleting a category may affect linked assets. Proceed?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 25px;">New Category</h3>
        <div class="card" style="padding: 40px; border-radius: 0;">
            <form action="" method="POST">
                <div style="margin-bottom: 2rem;">
                    <label style="display:block; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 1.5px; color: #888; margin-bottom: 15px;">Category Label</label>
                    <input type="text" name="cat_name" placeholder="e.g. Italian Silks" 
                           style="width:100%; padding:15px; border:none; border-bottom: 1px solid #eee; font-family: 'Playfair Display', serif; font-size: 1.2rem;" required>
                </div>

                <button type="submit" name="add_cat" 
                        style="background: #121417; color: white; border: none; padding: 18px; width: 100%; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; font-weight: 700; cursor: pointer;">
                    Update Database
                </button>
            </form>

            <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #eee;">
                <h4 style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1.5px; color: #c5a059; margin-bottom: 10px;">Categories Note</h4>
                <p style="font-size: 0.75rem; color: #888; line-height: 1.6;">
                    Categories serve as a way to organize your inventory. Ensure that the labels you use reflect the items properly.
                </p>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>