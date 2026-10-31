<?php
require_once __DIR__ . '/../../config/paths.php';

require_once __DIR__ . '/../Core/AdminSupport.php';
require_once __DIR__ . '/../Models/User.php';

class AdminCustomerController
{
    private User $user;

    public function __construct()
    {
        require __DIR__ . '/../../config/connection.php';

        $this->user = new User($db);
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
        $customers = $this->user->getAll($search);
        $flash = AdminSupport::pullFlash();
        $csrfToken = AdminSupport::csrfToken();

        require __DIR__ . '/../Views/admin/customers.php';
    }

    private function handlePost()
    {
        if (!AdminSupport::verifyCsrf()) {
            AdminSupport::flash('error', 'Your session expired. Please try again.');
            AdminSupport::redirect(nabta_public_url('admin/customers.php'));
        }

        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'create':
                $this->create();
                break;

            case 'update':
                $this->update();
                break;

            case 'delete':
                $this->delete();
                break;

            default:
                AdminSupport::flash('error', 'Unknown action.');
        }

        AdminSupport::redirect(nabta_public_url('admin/customers.php'));
    }

    // Read and validate the form fields. Returns [data, error].
    private function readForm(int $userId, bool $passwordRequired): array
    {
        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'role' => $_POST['role'] ?? '',
            'status' => $_POST['status'] ?? '',
            'password' => (string) ($_POST['password'] ?? '')
        ];

        if ($data['full_name'] === '' || mb_strlen($data['full_name']) > 100) {
            return [$data, 'Full name is required (max 100 characters).'];
        }

        if (
            !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ||
            mb_strlen($data['email']) > 150
        ) {
            return [$data, 'Please enter a valid email address.'];
        }

        if ($this->user->emailExists($data['email'], $userId)) {
            return [$data, 'This email is already used by another user.'];
        }

        if (mb_strlen($data['phone']) > 30) {
            return [$data, 'Phone number is too long (max 30 characters).'];
        }

        if (mb_strlen($data['address']) > 255) {
            return [$data, 'Address is too long (max 255 characters).'];
        }

        if (!in_array($data['role'], User::ROLES, true)) {
            return [$data, 'Invalid role.'];
        }

        if (!in_array($data['status'], User::STATUSES, true)) {
            return [$data, 'Invalid status.'];
        }

        if ($passwordRequired && strlen($data['password']) < 8) {
            return [$data, 'Password must be at least 8 characters.'];
        }

        if (!$passwordRequired && $data['password'] !== '' && strlen($data['password']) < 8) {
            return [$data, 'New password must be at least 8 characters.'];
        }

        // Empty optional fields are stored as NULL
        $data['phone'] = $data['phone'] === '' ? null : $data['phone'];
        $data['address'] = $data['address'] === '' ? null : $data['address'];

        return [$data, null];
    }

    private function create()
    {
        [$data, $error] = $this->readForm(0, true);

        if ($error) {
            AdminSupport::flash('error', $error);
            return;
        }

        $this->user->create($data);
        AdminSupport::flash('success', 'Customer created successfully.');
    }

    private function update()
    {
        $id = (int) ($_POST['user_id'] ?? 0);

        $existing = $id > 0 ? $this->user->find($id) : false;

        if (!$existing) {
            AdminSupport::flash('error', 'Customer not found.');
            return;
        }

        [$data, $error] = $this->readForm($id, false);

        if ($error) {
            AdminSupport::flash('error', $error);
            return;
        }

        // Never leave the store without an active admin
        $stillActiveAdmin = $data['role'] === 'admin' && $data['status'] === 'active';

        if (
            $existing['role'] === 'admin' &&
            $existing['status'] === 'active' &&
            !$stillActiveAdmin &&
            $this->user->isLastActiveAdmin($id)
        ) {
            AdminSupport::flash('error', 'You cannot demote or suspend the last active admin.');
            return;
        }

        $this->user->update($id, $data);
        AdminSupport::flash('success', 'Customer updated successfully.');
    }

    private function delete()
    {
        $id = (int) ($_POST['user_id'] ?? 0);

        $existing = $id > 0 ? $this->user->find($id) : false;

        if (!$existing) {
            AdminSupport::flash('error', 'Customer not found.');
            return;
        }

        if (
            $existing['role'] === 'admin' &&
            $existing['status'] === 'active' &&
            $this->user->isLastActiveAdmin($id)
        ) {
            AdminSupport::flash('error', 'You cannot delete the last active admin.');
            return;
        }

        try {
            $this->user->delete($id);
            AdminSupport::flash('success', 'Customer deleted.');
        } catch (PDOException $e) {
            // Foreign key: the customer already has orders, reviews, wishlist...
            if ($e->getCode() === '23000') {
                AdminSupport::flash(
                    'error',
                    'This customer has orders or other activity and cannot be deleted. Suspend the account instead.'
                );
            } else {
                error_log('Delete customer failed: ' . $e->getMessage());
                AdminSupport::flash('error', 'Unable to delete the customer.');
            }
        }
    }
}
