<?php
require_once __DIR__ . '/../../Core/AdminAccess.php';
$adminUser = require_admin_access();
require_once __DIR__ . '/../../../config/paths.php';
$asset = static fn($name) => e(nabta_public_url('assets/' . $name));
?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,nofollow"><title>Reviews | Nabta Botanical</title>
<?php foreach (['shared','style','canopy','admin','popups','palette-overrides','ui'] as $sheet): ?>
<link rel="stylesheet" href="<?= $asset('css/' . $sheet . '.css?v=' . filemtime(__DIR__ . '/../../../public/assets/css/' . $sheet . '.css')) ?>">
<?php endforeach; ?><script src="<?= $asset('js/ui.js') ?>" defer></script>
</head><body class="admin-body botanical-edition workspace-page admin-reviews">
<main id="main" tabindex="-1"><div class="admin-shell">
<?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>
<div class="admin-content"><?php $adminHeaderTitle = 'Reviews'; require __DIR__ . '/../layouts/admin-header.php'; ?>
<div class="admin-photo-strip" aria-hidden="true"></div><div class="admin-title"><div><h1>Reviews</h1><p>Manage customer feedback. Hidden reviews are excluded from public ratings.</p></div></div>
<?php if ($flash): ?><p class="flash <?= e($flash['type']) ?>" role="status"><?= e($flash['message']) ?></p><?php endif; ?>
<section class="panel"><form class="toolbar admin-search" method="get">
<label class="sr-only" for="search-records">Search reviews</label><input id="search-records" class="control" name="q" type="search" value="<?= e($search) ?>" placeholder="Search item, customer or review">
<label class="sr-only" for="rating-filter">Filter by rating</label><select id="rating-filter" class="control" name="rating"><option value="0">All ratings</option>
<?php for ($i=5; $i>=1; $i--): ?><option value="<?= $i ?>" <?= $rating === $i ? 'selected' : '' ?>><?= $i ?> stars</option><?php endfor; ?></select>
<button class="btn secondary">Search</button><span class="label" role="status"><?= count($reviews) ?> reviews</span></form>
<div class="table-scroll"><table><caption class="sr-only">Customer product and package reviews</caption><thead><tr>
<?php foreach (['Item','Type','Customer','Rating','Review','Status','Actions'] as $heading): ?><th scope="col"><?= $heading ?></th><?php endforeach; ?></tr></thead><tbody>
<?php if (!$reviews): ?><tr><td colspan="7">No reviews match these filters. <a href="<?= e(nabta_public_url('admin/reviews.php')) ?>">Clear filters</a></td></tr><?php endif; ?>
<?php foreach ($reviews as $review): $id=(int)$review['review_id']; ?>
<tr class="<?= $review['is_hidden'] ? 'is-hidden-review' : 'is-published-review' ?>"><td data-label="Item"><?= e($review['item_name']) ?></td><td data-label="Type"><?= e($review['item_type']) ?></td><td data-label="Customer"><?= e($review['customer_name'] ?? 'Customer') ?></td>
<td data-label="Rating"><span class="rating" aria-label="<?= (int)$review['rating'] ?> out of 5 stars"><?= str_repeat('★', (int)$review['rating']) . str_repeat('☆', 5-(int)$review['rating']) ?></span></td>
<td data-label="Review"><?= e($review['comment']) ?></td><td data-label="Status"><span class="review-status"><?= $review['is_hidden'] ? 'Hidden' : 'Published' ?></span></td>
<td data-label="Actions"><div class="table-actions"><button class="table-button" type="button" popovertarget="review-<?= $id ?>">View</button>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>"><input type="hidden" name="review_id" value="<?= $id ?>"><input type="hidden" name="action" value="<?= $review['is_hidden'] ? 'unhide' : 'hide' ?>"><button class="table-button hide-button <?= $review['is_hidden'] ? 'publish-review' : 'hide-review' ?>"><?= $review['is_hidden'] ? 'Publish' : 'Hide' ?></button></form>
<button class="table-button delete-button" type="button" popovertarget="delete-review-<?= $id ?>">Delete</button></div></td></tr>
<?php endforeach; ?></tbody></table></div></section></div></div>
<?php foreach ($reviews as $review): $id=(int)$review['review_id']; ?>
<section class="popover" popover id="review-<?= $id ?>" aria-labelledby="review-title-<?= $id ?>"><div class="popover-top"><h2 id="review-title-<?= $id ?>">Review #<?= $id ?></h2><button class="icon-btn" type="button" popovertarget="review-<?= $id ?>" popovertargetaction="hide" aria-label="Close window">×</button></div>
<p><strong><?= e($review['item_name']) ?></strong> · <?= (int)$review['rating'] ?>/5</p><p><?= e($review['comment']) ?></p><p>By <?= e($review['customer_name'] ?? 'Customer') ?> · <?= e($review['created_at']) ?></p></section>
<section class="popover" popover id="delete-review-<?= $id ?>" aria-labelledby="delete-review-title-<?= $id ?>"><div class="popover-top"><h2 id="delete-review-title-<?= $id ?>">Delete this review?</h2><button class="icon-btn" type="button" popovertarget="delete-review-<?= $id ?>" popovertargetaction="hide" aria-label="Close window">×</button></div>
<p>This permanently removes review #<?= $id ?>. You can hide it instead to keep the record.</p>
<form method="post"><input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>"><input type="hidden" name="review_id" value="<?= $id ?>"><input type="hidden" name="action" value="delete"><button class="btn btn-danger">Delete review</button><button class="btn secondary" type="button" popovertarget="delete-review-<?= $id ?>" popovertargetaction="hide">Keep review</button></form></section>
<?php endforeach; ?></main></body></html>