<?php
// 1. Start the session for user alerts/messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Set Timezone (Useful for your Sales timestamps)
date_default_timezone_set('UTC'); 

// 3. Include the database connection
require_once('db_connect.php');

// 4. Global Site Settings
$site_name = "StitchStock Apparel";
$low_stock_threshold = 10; // We can use this variable in our reports later