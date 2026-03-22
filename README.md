# StitchStock Ledger: System Documentation

# 1\. Overview

The StitchStock Ledger is a specialized inventory management system (IMS) developed for clothiers. Unlike generic retail software, this system uses a "Journal" approach to inventory, where every stock change is treated as a ledger entry. The system provides real-time business intelligence through "Inventory Velocity" and "Risk Exposure" metrics, allowing a tailor to monitor material outflow and depletion rates through a minimalist, editorial-inspired interface.

# 2\. Constraints

To maintain the integrity of the ledger, the following operational constraints are enforced:

* Referential Integrity: Categories cannot be deleted via standard protocols if they are linked to active products. The "Delete" function must be used to bypass this via temporary foreign-key suspension.  
* Non-Negative Inventory: The system prevents "Short Selling." A sale cannot be processed if the requested quantity exceeds the current physical stock in the registry.  
* Data Persistence: The system utilizes an SQLite flat-file database. While highly portable, it is limited to sequential write operations; concurrent high-volume transactions are not supported.  
* Scale: The dashboard is optimized for a curated collection of up to 500 unique SKUs.

# 3\. Setup Guide

1. Environment: Ensure a PHP-enabled web server (XAMPP, WAMP, or NGINX) is running.  
2. Download the repository and rename the folder into “StitchStock 2.0”.  
3. Paste the folder into the htdocs folder (XAMPP root folder)

# 4\. How to Use

* Initializing the Inventory: Navigate to Manage Categories. Create your categories (e.g., "Business Attire," "Casual Wear").  
* Adding Stock: Use the Add Product form. Input the name, select the category, set the initial stock, and pricing per unit.  
* Processing a Sale: Select an item from the dropdown in the Sales section. The "Stock Guard" will automatically check availability. Enter the quantity and "Finalize Transaction."  
* Monitoring Health: Check the Dashboard.  
  * Gold Bars indicate items reaching Low Stock.  
  * Red Bars indicate Depleted Stock.

# 5\. File Definitions

* index.php (The Dashboard): The central intelligence hub. It calculates the 30-day movement velocity and displays the activity timeline.  
* inventory.php: Displays the full inventory. It features an asynchronous search bar to filter the inventory instantly.  
* manage\_categories.php: The configuration file for inventory classification.  
* sales\_form.php: The transactional interface where inventory is decremented and revenue is recorded.  
* maintenance\_logic.php: The system utility file used for resetting the database (Full Data Reset).  
* assets/js/script.js: This file handles the live search logic and the real-time stock-check during sales.  
* includes/db\_connect.php: The PDO (PHP Data Objects) connection string that links the logic to the SQLite database.

# 

# 6\. Troubleshooting

| Issue | Cause | Resolution |
| :---- | :---- | :---- |
| "Insufficient Stock" button locked | You are trying to sell more than the item stock. | Check the current stock in the Inventory. |
| Search bar not filtering | The script.js file is not loading or the table class is missing. | Inspect the page (F12) to ensure script.js is linked in the header. |
| Database is locked | Multiple processes are trying to write to the SQLite file at once. | Refresh the page and wait 1-2 seconds between transactions. |
| Categories won't delete | Active products are still assigned to that category. | Use the "Delete" button in Manage Categories to force the deletion. |
| Dashboard stats are 0% | No sales have been recorded in the last 30 days. | Process a test sale to initialize the movement velocity logic. |

