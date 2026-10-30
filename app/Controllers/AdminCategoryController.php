<?php
require_once __DIR__ . '/../../config/paths.php';

require_once __DIR__ . '/../Core/AdminSupport.php';
require_once __DIR__ . '/../Models/Category.php';

class AdminCategoryController
{
    private Category $category;

    public function __construct()
    {
        $this->category = new Category();
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
        $categories = $this->category->getAll($search);
        $flash = AdminSupport::pullFlash();
        $csrfToken = AdminSupport::csrfToken();

        require __DIR__ . '/../Views/admin/categories.php';
    }

    private function handlePost()
    {
        if (!AdminSupport::verifyCsrf()) {
            AdminSupport::flash('error', 'Your session expired. Please try again.');
            AdminSupport::redirect(nabta_public_url('admin/categories.php'));
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

        AdminSupport::redirect(nabta_public_url('admin/categories.php'));
    }

    // Returns [name, description, error]
    private function readForm(int $catId): array
    {
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($name === '' || mb_strlen($name) > 100) {
            return [$name, $description, 'Category name is required (max 100 characters).'];
        }

        if (mb_strlen($description) > 1000) {
            return [$name, $description, 'Description is too long (max 1000 characters).'];
        }

        if ($this->category->nameExists($name, $catId)) {
            return [$name, $description, 'A category with this name already exists.'];
        }

        return [$name, $description === '' ? null : $description, null];
    }

    private function create()
    {
        [$name, $description, $error] = $this->readForm(0);

        if ($error) {
            AdminSupport::flash('error', $error);
            return;
        }

        $this->category->create($name, $description);
        AdminSupport::flash('success', 'Category created successfully.');
    }

    private function update()
    {
        $id = (int) ($_POST['cat_id'] ?? 0);

        if ($id <= 0 || !$this->category->find($id)) {
            AdminSupport::flash('error', 'Category not found.');
            return;
        }

        [$name, $description, $error] = $this->readForm($id);

        if ($error) {
            AdminSupport::flash('error', $error);
            return;
        }

        $this->category->update($id, $name, $description);
        AdminSupport::flash('success', 'Category updated successfully.');
    }

    private function delete()
    {
        $id = (int) ($_POST['cat_id'] ?? 0);

        if ($id <= 0 || !$this->category->find($id)) {
            AdminSupport::flash('error', 'Category not found.');
            return;
        }

        if ($this->category->countProducts($id) > 0) {
            AdminSupport::flash(
                'error',
                'This category still has products. Move or remove them first.'
            );
            return;
        }

        try {
            $this->category->delete($id);
            AdminSupport::flash('success', 'Category deleted.');
        } catch (PDOException $e) {
            error_log('Delete category failed: ' . $e->getMessage());
            AdminSupport::flash('error', 'Unable to delete the category.');
        }
    }
}
