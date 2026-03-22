<?php
// Prevent direct access to this file for security
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    exit('No direct script access allowed');
}

try {
    // Define the path to your SQLite file
    // __DIR__ points to the 'includes' folder, so we go up one level to find the .db
    $db_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'stitchstock.db';
    
    $pdo = new PDO("sqlite:" . $db_path);
    
    // Set error mode to Exceptions so we can catch mistakes easily
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Support for Foreign Keys (Important for your Sales -> Products relationship)
    $pdo->exec("PRAGMA foreign_keys = ON;");

} catch (PDOException $e) {
    // If the database is missing or locked, stop the script and show why
    die("CRITICAL ERROR: Could not connect to the database. " . $e->getMessage());
}