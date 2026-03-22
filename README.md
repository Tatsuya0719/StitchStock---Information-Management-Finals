# 1\. Project Overview

StitchStock is a custom-built Boutique Management System designed to handle inventory tracking, point-of-sale transactions, and financial reporting. It utilizes a PHP/SQLite stack to provide a fast, serverless experience that can be deployed locally via XAMPP.

# 2\. Constraints & System Architecture

* Database: SQLite (stitchstock.db). This choice ensures portability, as the entire database resides in a single file within the project root.  
* Environment: Built for XAMPP (Apache/MySQL stack), specifically utilizing PHP 8.2.  
* UI/UX: Custom CSS-based sidebar navigation with a responsive grid layout for data cards and tables.

# 3\. Installation & Setup

1. Server Placement: Move the StitchStock 2.0 folder into your local server's root directory (e.g., C:\\XAMPP\\htdocs\\).  
2. Database Permission: Ensure the directory has write permissions so the SQLite engine can update stitchstock.db.  
3. Access: Navigate to http://localhost/stitchstock%202.0/ in a web browser.

---

# 4\. Detailed File Explanation

## A. Global Includes (/includes)

* config.php: The primary database connection file using PDO (PHP Data Objects) to interface with the SQLite file.  
* db\_connect.php: A secondary helper for database instantiation.  
* header.php: Contains the HTML \<head\>, global CSS links, and the sidebar navigation menu seen on all pages.  
* footer.php: Closes global HTML tags and includes common JavaScript files like main.js.

## B. Core Functional Pages

* index.php (Dashboard): Fetches real-time stats from the database. It includes logic for "Restock Alerts" by querying products where the quantity is below a set threshold.  
* inventory.php: Displays the full list of apparel. It provides a central view of all stock currently stored in the system.  
* sales\_form.php & process\_sale.php: The Point of Sale (POS) system. sales\_form.php captures user input, while process\_sale.php updates the stock levels and records the transaction in the Sales table.  
* reports.php: The financial hub. It calculates Total Revenue using SUM(total) from the Sales table and lists recent transactions.

## C. Data Management

* add\_product\_form.php: The interface for entering new items into the boutique.  
* edit\_form.php & edit.php: Handles stock updates. If a user clicks "Restock" on the dashboard, it passes a prod\_id to these files to modify existing records.  
* delete.php: Handles product removal, governed by Foreign Key constraints to prevent breaking sales history.

## D. System Maintenance

* manage\_categories.php: Allows the user to create and view apparel categories (e.g., Shoes, Jackets).  
* maintenance\_logic.php: The "Nuclear Option" logic. It processes the Full System Reset, which wipes both Sales and Products tables and resets auto-incrementing IDs.

## E. Assets (/assets)

* css/styles.css: Defines the modern "dark sidebar" aesthetic and the card-based layout for the reports.  
* js/main.js: Handles frontend interactivity, such as the confirmation popups before deleting data or resetting the system.

---

## 5\. Troubleshooting & FAQ

* Error: 404 Not Found: This typically occurs if a file is called from the wrong directory or contains a space in the filename that isn't properly encoded.  
* Error: No such column: This is a common SQL error caused by a mismatch between the PHP variable names (like $qty) and the actual SQLite table columns (like total).


