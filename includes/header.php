<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StitchStock | Management System</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="assets/js/main.js" defer></script>
</head>
<body>

    <div class="sidebar">
        <div class="logo">
            <h2 class="logo-text">StitchStock</h2>
            <small style="letter-spacing: 2px; text-transform: uppercase; font-size: 0.6rem; color: #999;">
                Admin Page v2.0
            </small>
        </div>

        <nav style="margin-top: 3rem; display: flex; flex-direction: column;">
            <a href="index.php" class="nav-link">Dashboard</a>
            <a href="inventory.php" class="nav-link">Inventory List</a>
            <a href="reports.php" class="nav-link">The Ledger</a>
            <a href="sales_form.php" class="nav-link">Register Sales</a>
        </nav>

        <div style="margin-top: auto; padding-top: 2rem;">
            <a href="add_product_form.php" class="btn-primary" style="background: var(--ledger-charcoal); color: white; display: block; text-align: center; text-decoration: none; padding: 12px; font-size: 0.7rem; letter-spacing: 1px;">
                ADD NEW ITEM
            </a>
        </div>
    </div>

    <div class="main-content">