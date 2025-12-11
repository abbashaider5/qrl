<?php
require __DIR__.'/includes/db.php';

echo "Contacts Table Structure:\n";
echo "==========================\n\n";

$stmt = $pdo->query('DESCRIBE contacts');
while ($row = $stmt->fetch()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
