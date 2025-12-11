<?php
require __DIR__.'/includes/db.php';
echo 'Total contacts: ' . $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
