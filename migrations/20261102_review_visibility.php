<?php
declare(strict_types=1);
require __DIR__ . '/../config/connection.php';
$columns = $db->query('SHOW COLUMNS FROM reviews')->fetchAll(PDO::FETCH_COLUMN);
if (!in_array('is_hidden', $columns, true)) $db->exec('ALTER TABLE reviews ADD COLUMN is_hidden TINYINT(1) NOT NULL DEFAULT 0');
echo "Review visibility schema is ready.\n";
