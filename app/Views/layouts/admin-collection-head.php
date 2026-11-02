<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,nofollow"><title><?= e($pageTitle) ?> | Nabta Botanical</title>
<link rel="icon" href="<?= e(nabta_public_url('assets/img/favicon.svg')) ?>" type="image/svg+xml">
<?php foreach (['shared','style','canopy','admin','popups','palette-overrides','ui','admin-collections'] as $sheet): ?>
<link rel="stylesheet" href="<?= e(nabta_public_url('assets/css/'.$sheet.'.css?v='.filemtime(__DIR__.'/../../../public/assets/css/'.$sheet.'.css'))) ?>">
<?php endforeach; ?><script src="<?= e(nabta_public_url('assets/js/ui.js?v='.filemtime(__DIR__.'/../../../public/assets/js/ui.js'))) ?>" defer></script>
