<?php
$db = new SQLite3('messages.db');

$createTableQuery = 'CREATE TABLE IF NOT EXISTS messages (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  message TEXT,
  viewed BOOLEAN DEFAULT 0,
  timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
)';
$db->exec($createTableQuery);

$createAdminTableQuery = 'CREATE TABLE IF NOT EXISTS admin (
  username TEXT,
  password TEXT
)';
$db->exec($createAdminTableQuery);

$adminQuery = "INSERT OR IGNORE INTO admin (username, password) VALUES ('Admin', '12345')";
$db->exec($adminQuery);
?>
