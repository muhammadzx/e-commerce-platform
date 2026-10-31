<?php
require_once __DIR__ . '/../../config/paths.php';

require_once __DIR__ . '/../Core/AdminSupport.php';
require_once __DIR__ . '/../Models/Order.php';

class AdminOrderController
{
    private Order $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function handle()
    {
        AdminSupport::start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePost();
            return;
        }

        $this->index();
    }

    private function index()
    {
        $search = trim($_GET['q'] ?? '');
        $orders = $this->order->getAll($search);
        $itemsByOrder = $this->order->getItemsByOrderIds(array_column($orders, 'cart_id'));
        $flash = AdminSupport::pullFlash();
        $csrfToken = AdminSupport::csrfToken();

        require __DIR__ . '/../Views/admin/orders.php';
    }

    private function handlePost()
    {
        if (!AdminSupport::verifyCsrf()) {
            AdminSupport::flash('error', 'Your session expired. Please try again.');
            AdminSupport::redirect(nabta_public_url('admin/orders.php'));
        }

        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'update':
                $this->update();
                break;

            case 'delete':
                $this->delete();
                break;

            default:
                AdminSupport::flash('error', 'Unknown action.');
        }

        AdminSupport::redirect(nabta_public_url('admin/orders.php'));
    }

    private function update()
    {
        $id = (int) ($_POST['order_id'] ?? 0);

        if ($id <= 0 || !$this->order->find($id)) {
            AdminSupport::flash('error', 'Order not found.');
            return;
        }

        $status = $_POST['status'] ?? '';

        if (!in_array($status, Order::STATUSES, true)) {
            AdminSupport::flash('error', 'Invalid order status.');
            return;
        }

        $this->order->update($id, $status);

        AdminSupport::flash('success', 'Order #' . $id . ' updated successfully.');
    }

    private function delete()
    {
        $id = (int) ($_POST['order_id'] ?? 0);

        if ($id <= 0 || !$this->order->find($id)) {
            AdminSupport::flash('error', 'Order not found.');
            return;
        }

        try {
            $this->order->delete($id);
            AdminSupport::flash('success', 'Order #' . $id . ' and its reviews were deleted.');
        } catch (PDOException $e) {
            error_log('Delete order failed: ' . $e->getMessage());
            AdminSupport::flash('error', 'Unable to delete the order.');
        }
    }
}