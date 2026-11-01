<?php
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 762eb24f391f21bd6900764f732171216007a8a9
declare(strict_types=1);

require_once __DIR__ . '/../../config/paths.php';
require_once __DIR__ . '/../../app/Core/AdminAccess.php';

$adminUser = require_admin_access();
require __DIR__ . '/../../app/Views/admin/orders.php';
<<<<<<< HEAD
=======
require_once __DIR__ . '/../../config/paths.php';

require_once __DIR__ . '/../../app/Controllers/AdminOrderController.php';

$controller = new AdminOrderController();
$controller->handle();
>>>>>>> 24d0e2a2c4d6faa9f96aa68644886762c776df04
=======
>>>>>>> 762eb24f391f21bd6900764f732171216007a8a9
