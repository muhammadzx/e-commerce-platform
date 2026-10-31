<?php
require_once __DIR__ . '/../../config/paths.php';

require_once __DIR__ . '/../Core/AdminSupport.php';
require_once __DIR__ . '/../Models/Wishlist.php';

class WishlistController
{
    private Wishlist $wishlist;

    public function __construct()
    {
        $this->wishlist = new Wishlist();
    }

    // 0 when nobody is logged in
    private function currentUserId(): int
    {
        AdminSupport::start();

        return (int) ($_SESSION['user_id'] ?? 0);
    }

    // The wishlist page: GET shows it, POST handles remove / add to basket
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
        $userId = $this->currentUserId();
        $isLoggedIn = $userId > 0;

        $items = $isLoggedIn ? $this->wishlist->getByUser($userId) : [];
        $basketCount = $isLoggedIn ? $this->wishlist->basketCount($userId) : 0;
        $flash = AdminSupport::pullFlash();
        $csrfToken = AdminSupport::csrfToken();

        require __DIR__ . '/../Views/wishlist.php';
    }

    private function handlePost()
    {
        $pageUrl = nabta_public_url('index.php?page=wishlist');
        $userId = $this->currentUserId();

        if ($userId <= 0) {
            AdminSupport::flash('error', 'Please sign in first.');
            AdminSupport::redirect($pageUrl);
        }

        if (!AdminSupport::verifyCsrf()) {
            AdminSupport::flash('error', 'Your session expired. Please try again.');
            AdminSupport::redirect($pageUrl);
        }

        $action = $_POST['action'] ?? '';
        $wishlistId = (int) ($_POST['wishlist_id'] ?? 0);

        // The item must exist and belong to the logged-in user
        $item = $wishlistId > 0 ? $this->wishlist->findForUser($wishlistId, $userId) : false;

        if (!$item) {
            AdminSupport::flash('error', 'This item is not in your wishlist.');
            AdminSupport::redirect($pageUrl);
        }

        switch ($action) {
            case 'remove':
                $this->wishlist->remove($wishlistId, $userId);
                AdminSupport::flash('success', '"' . $item['name'] . '" was removed from your wishlist.');
                break;

            case 'add_to_basket':
                [$ok, $message] = $this->wishlist->addToBasket($userId, $item);
                AdminSupport::flash($ok ? 'success' : 'error', $message);
                break;

            default:
                AdminSupport::flash('error', 'Unknown action.');
        }

        AdminSupport::redirect($pageUrl);
    }

    // JSON API used by the heart button on the product page
    public function toggle()
    {
        header('Content-Type: application/json; charset=utf-8');

        $userId = $this->currentUserId();

        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Please log in to use your wishlist.'
            ]);
            return;
        }

        if (!AdminSupport::verifyCsrf()) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Invalid form token. Please refresh the page.'
            ]);
            return;
        }

        $productId = filter_input(INPUT_POST, 'pro_id', FILTER_VALIDATE_INT);

        if (!$productId || $productId <= 0 || !$this->wishlist->productExists($productId)) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'Product not found.'
            ]);
            return;
        }

        $inWishlist = $this->wishlist->toggleProduct($userId, $productId);

        echo json_encode([
            'success' => true,
            'in_wishlist' => $inWishlist,
            'message' => $inWishlist ? 'Saved to your wishlist.' : 'Removed from your wishlist.'
        ]);
    }
}