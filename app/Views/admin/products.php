<?php
require_once __DIR__ . '/../../../config/paths.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Manage products | NABTA Botanical</title>
    <meta name="description" content="NABTA Botanical admin workspace.">
    <meta name="robots" content="noindex,nofollow">
    <meta name="theme-color" content="#c5d4b4">
    <link rel="icon" href="<?= htmlspecialchars(nabta_public_url('assets/img/favicon.svg'), ENT_QUOTES, 'UTF-8') ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/shared.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/style.css'), ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="<?= htmlspecialchars(nabta_public_url('assets/css/canopy.css'), ENT_QUOTES, 'UTF-8') ?>">
</head>

<body class="admin-body botanical-edition workspace-page admin-products">
        <main id="main">
        <div class="admin-shell">
            <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>
            <div class="admin-content">
                <div class="admin-top"><span>Workspace / Products</span>
                    <div class="flex"><span>Nabta Botanical</span><span class="pill">Preview</span></div>
                </div>
                <div class="admin-photo-strip" role="img" aria-label="Soft-focus botanical greenhouse photograph">
                    <span>CANOPY / BOTANICAL OPERATIONS<small>GROWTH · STOCK · CUSTOMER CARE</small></span></div>
                <div class="admin-title">
                    <div>
                        <h1>Products</h1>
                        <p>Manage plants, growing essentials, and seller listings.</p>
                    </div><button class="btn" popovertarget="add">+ Add new</button>
                </div>
                <section class="panel">
                    <div class="toolbar"><label class="sr-only" for="search-records">Search products</label><input
                            class="control" id="search-records" type="search" placeholder="Search products"><button
                            class="btn secondary" popovertarget="preview">Search <svg class="icon" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <circle cx="10" cy="10" r="6"></circle>
                                <path d="m15 15 5 5"></path>
                            </svg></button><span class="label">6 records</span></div>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Product">
                                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/plant.jpg'), ENT_QUOTES, 'UTF-8') ?>"
                                                alt=""><span>The Rubber Plant</span></div>
                                    </td>
                                    <td data-label="Category">Plants</td>
                                    <td data-label="Price">24.00 JOD</td>
                                    <td data-label="Stock">24</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-0">View</button><button class="table-button"
                                                popovertarget="edit-0">Edit</button><button class="table-button"
                                                popovertarget="delete-0">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Product">
                                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/pot.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt=""><span>The
                                                Stone Planter</span></div>
                                    </td>
                                    <td data-label="Category">Pots</td>
                                    <td data-label="Price">18.00 JOD</td>
                                    <td data-label="Stock">21</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-1">View</button><button class="table-button"
                                                popovertarget="edit-1">Edit</button><button class="table-button"
                                                popovertarget="delete-1">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Product">
                                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/soil.jpg'), ENT_QUOTES, 'UTF-8') ?>"
                                                alt=""><span>Everyday Potting Mix</span></div>
                                    </td>
                                    <td data-label="Category">Soil &amp; nutrition</td>
                                    <td data-label="Price">8.00 JOD</td>
                                    <td data-label="Stock">18</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-2">View</button><button class="table-button"
                                                popovertarget="edit-2">Edit</button><button class="table-button"
                                                popovertarget="delete-2">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Product">
                                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/tools.jpg'), ENT_QUOTES, 'UTF-8') ?>"
                                                alt=""><span>The Garden Duo</span></div>
                                    </td>
                                    <td data-label="Category">Tools</td>
                                    <td data-label="Price">16.00 JOD</td>
                                    <td data-label="Stock">15</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-3">View</button><button class="table-button"
                                                popovertarget="edit-3">Edit</button><button class="table-button"
                                                popovertarget="delete-3">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Product">
                                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/decor.jpg'), ENT_QUOTES, 'UTF-8') ?>"
                                                alt=""><span>The Desk Garden</span></div>
                                    </td>
                                    <td data-label="Category">Decor</td>
                                    <td data-label="Price">14.00 JOD</td>
                                    <td data-label="Stock">12</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-4">View</button><button class="table-button"
                                                popovertarget="edit-4">Edit</button><button class="table-button"
                                                popovertarget="delete-4">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Product">
                                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/care.jpg'), ENT_QUOTES, 'UTF-8') ?>"
                                                alt=""><span>Leaf-care Treatment</span></div>
                                    </td>
                                    <td data-label="Category">Care &amp; treatments</td>
                                    <td data-label="Price">12.00 JOD</td>
                                    <td data-label="Stock">9</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-5">View</button><button class="table-button"
                                                popovertarget="edit-5">Edit</button><button class="table-button"
                                                popovertarget="delete-5">Delete</button></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
            <section id="view-0" class="popover" popover aria-labelledby="view-0-title">
                <div class="popover-top">
                    <h2 id="view-0-title">Products / Record 1</h2><button class="icon-btn" popovertarget="view-0"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Product</span><span>
                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/plant.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt=""><span>The Rubber
                                Plant</span></div>
                    </span></div>
                <div class="summary-row"><span>Category</span><span>Plants</span></div>
                <div class="summary-row"><span>Price</span><span>24.00 JOD</span></div>
                <div class="summary-row"><span>Stock</span><span>24</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-0" class="popover" popover aria-labelledby="edit-0-title">
                <div class="popover-top">
                    <h2 id="edit-0-title">Edit record</h2><button class="icon-btn" popovertarget="edit-0"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-0-name">Product name</label><input id="edit-0-name"
                        name="edit-0-name" type="text" value="The Rubber Plant"></div>
                <div class="form-grid">
                    <div class="field"><label for="edit-0-cat">Category</label><select id="edit-0-cat"
                            name="edit-0-cat">
                            <option>Plants</option>
                            <option>Pots</option>
                            <option>Soil &amp; nutrition</option>
                            <option>Tools</option>
                            <option>Decor</option>
                            <option>Care &amp; treatments</option>
                        </select></div>
                    <div class="field"><label for="edit-0-price">Price (JOD)</label><input id="edit-0-price"
                            name="edit-0-price" type="number" value="24"></div>
                    <div class="field"><label for="edit-0-stock">Stock</label><input id="edit-0-stock"
                            name="edit-0-stock" type="number" value="24"></div>
                    <div class="field"><label for="edit-0-status">Status</label><select id="edit-0-status"
                            name="edit-0-status">
                            <option>Active</option>
                            <option>Draft</option>
                            <option>Under review</option>
                            <option>Rejected</option>
                        </select></div>
                </div>
                <div class="field"><label for="edit-0-image">Product image</label><input id="edit-0-image"
                        name="edit-0-image" type="file" value=""></div>
                <div class="field"><label for="edit-0-description">Description / verified label details</label><textarea
                        id="edit-0-description" rows="2"></textarea></div><button class="btn" type="button"
                    popovertarget="preview">Save changes</button>
            </section>
            <section id="delete-0" class="popover" popover aria-labelledby="delete-0-title">
                <div class="popover-top">
                    <h2 id="delete-0-title">Delete this record?</h2><button class="icon-btn" popovertarget="delete-0"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <p>Confirm removal of the selected record. No data is deleted in this static preview.</p>
                <div class="flex" style="margin-top:18px"><button class="btn" type="button"
                        popovertarget="preview">Delete record</button><button class="btn secondary"
                        popovertarget="delete-0" popovertargetaction="hide">Keep record</button></div>
            </section>
            <section id="view-1" class="popover" popover aria-labelledby="view-1-title">
                <div class="popover-top">
                    <h2 id="view-1-title">Products / Record 2</h2><button class="icon-btn" popovertarget="view-1"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Product</span><span>
                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/pot.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt=""><span>The Stone
                                Planter</span></div>
                    </span></div>
                <div class="summary-row"><span>Category</span><span>Pots</span></div>
                <div class="summary-row"><span>Price</span><span>18.00 JOD</span></div>
                <div class="summary-row"><span>Stock</span><span>21</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-1" class="popover" popover aria-labelledby="edit-1-title">
                <div class="popover-top">
                    <h2 id="edit-1-title">Edit record</h2><button class="icon-btn" popovertarget="edit-1"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-1-name">Product name</label><input id="edit-1-name"
                        name="edit-1-name" type="text" value="The Stone Planter"></div>
                <div class="form-grid">
                    <div class="field"><label for="edit-1-cat">Category</label><select id="edit-1-cat"
                            name="edit-1-cat">
                            <option>Plants</option>
                            <option>Pots</option>
                            <option>Soil &amp; nutrition</option>
                            <option>Tools</option>
                            <option>Decor</option>
                            <option>Care &amp; treatments</option>
                        </select></div>
                    <div class="field"><label for="edit-1-price">Price (JOD)</label><input id="edit-1-price"
                            name="edit-1-price" type="number" value="18"></div>
                    <div class="field"><label for="edit-1-stock">Stock</label><input id="edit-1-stock"
                            name="edit-1-stock" type="number" value="21"></div>
                    <div class="field"><label for="edit-1-status">Status</label><select id="edit-1-status"
                            name="edit-1-status">
                            <option>Active</option>
                            <option>Draft</option>
                            <option>Under review</option>
                            <option>Rejected</option>
                        </select></div>
                </div>
                <div class="field"><label for="edit-1-image">Product image</label><input id="edit-1-image"
                        name="edit-1-image" type="file" value=""></div>
                <div class="field"><label for="edit-1-description">Description / verified label details</label><textarea
                        id="edit-1-description" rows="2"></textarea></div><button class="btn" type="button"
                    popovertarget="preview">Save changes</button>
            </section>
            <section id="delete-1" class="popover" popover aria-labelledby="delete-1-title">
                <div class="popover-top">
                    <h2 id="delete-1-title">Delete this record?</h2><button class="icon-btn" popovertarget="delete-1"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <p>Confirm removal of the selected record. No data is deleted in this static preview.</p>
                <div class="flex" style="margin-top:18px"><button class="btn" type="button"
                        popovertarget="preview">Delete record</button><button class="btn secondary"
                        popovertarget="delete-1" popovertargetaction="hide">Keep record</button></div>
            </section>
            <section id="view-2" class="popover" popover aria-labelledby="view-2-title">
                <div class="popover-top">
                    <h2 id="view-2-title">Products / Record 3</h2><button class="icon-btn" popovertarget="view-2"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Product</span><span>
                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/soil.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt=""><span>Everyday Potting
                                Mix</span></div>
                    </span></div>
                <div class="summary-row"><span>Category</span><span>Soil &amp; nutrition</span></div>
                <div class="summary-row"><span>Price</span><span>8.00 JOD</span></div>
                <div class="summary-row"><span>Stock</span><span>18</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-2" class="popover" popover aria-labelledby="edit-2-title">
                <div class="popover-top">
                    <h2 id="edit-2-title">Edit record</h2><button class="icon-btn" popovertarget="edit-2"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-2-name">Product name</label><input id="edit-2-name"
                        name="edit-2-name" type="text" value="Everyday Potting Mix"></div>
                <div class="form-grid">
                    <div class="field"><label for="edit-2-cat">Category</label><select id="edit-2-cat"
                            name="edit-2-cat">
                            <option>Plants</option>
                            <option>Pots</option>
                            <option>Soil &amp; nutrition</option>
                            <option>Tools</option>
                            <option>Decor</option>
                            <option>Care &amp; treatments</option>
                        </select></div>
                    <div class="field"><label for="edit-2-price">Price (JOD)</label><input id="edit-2-price"
                            name="edit-2-price" type="number" value="8"></div>
                    <div class="field"><label for="edit-2-stock">Stock</label><input id="edit-2-stock"
                            name="edit-2-stock" type="number" value="18"></div>
                    <div class="field"><label for="edit-2-status">Status</label><select id="edit-2-status"
                            name="edit-2-status">
                            <option>Active</option>
                            <option>Draft</option>
                            <option>Under review</option>
                            <option>Rejected</option>
                        </select></div>
                </div>
                <div class="field"><label for="edit-2-image">Product image</label><input id="edit-2-image"
                        name="edit-2-image" type="file" value=""></div>
                <div class="field"><label for="edit-2-description">Description / verified label details</label><textarea
                        id="edit-2-description" rows="2"></textarea></div><button class="btn" type="button"
                    popovertarget="preview">Save changes</button>
            </section>
            <section id="delete-2" class="popover" popover aria-labelledby="delete-2-title">
                <div class="popover-top">
                    <h2 id="delete-2-title">Delete this record?</h2><button class="icon-btn" popovertarget="delete-2"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <p>Confirm removal of the selected record. No data is deleted in this static preview.</p>
                <div class="flex" style="margin-top:18px"><button class="btn" type="button"
                        popovertarget="preview">Delete record</button><button class="btn secondary"
                        popovertarget="delete-2" popovertargetaction="hide">Keep record</button></div>
            </section>
            <section id="view-3" class="popover" popover aria-labelledby="view-3-title">
                <div class="popover-top">
                    <h2 id="view-3-title">Products / Record 4</h2><button class="icon-btn" popovertarget="view-3"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Product</span><span>
                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/tools.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt=""><span>The Garden
                                Duo</span></div>
                    </span></div>
                <div class="summary-row"><span>Category</span><span>Tools</span></div>
                <div class="summary-row"><span>Price</span><span>16.00 JOD</span></div>
                <div class="summary-row"><span>Stock</span><span>15</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-3" class="popover" popover aria-labelledby="edit-3-title">
                <div class="popover-top">
                    <h2 id="edit-3-title">Edit record</h2><button class="icon-btn" popovertarget="edit-3"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-3-name">Product name</label><input id="edit-3-name"
                        name="edit-3-name" type="text" value="The Garden Duo"></div>
                <div class="form-grid">
                    <div class="field"><label for="edit-3-cat">Category</label><select id="edit-3-cat"
                            name="edit-3-cat">
                            <option>Plants</option>
                            <option>Pots</option>
                            <option>Soil &amp; nutrition</option>
                            <option>Tools</option>
                            <option>Decor</option>
                            <option>Care &amp; treatments</option>
                        </select></div>
                    <div class="field"><label for="edit-3-price">Price (JOD)</label><input id="edit-3-price"
                            name="edit-3-price" type="number" value="16"></div>
                    <div class="field"><label for="edit-3-stock">Stock</label><input id="edit-3-stock"
                            name="edit-3-stock" type="number" value="15"></div>
                    <div class="field"><label for="edit-3-status">Status</label><select id="edit-3-status"
                            name="edit-3-status">
                            <option>Active</option>
                            <option>Draft</option>
                            <option>Under review</option>
                            <option>Rejected</option>
                        </select></div>
                </div>
                <div class="field"><label for="edit-3-image">Product image</label><input id="edit-3-image"
                        name="edit-3-image" type="file" value=""></div>
                <div class="field"><label for="edit-3-description">Description / verified label details</label><textarea
                        id="edit-3-description" rows="2"></textarea></div><button class="btn" type="button"
                    popovertarget="preview">Save changes</button>
            </section>
            <section id="delete-3" class="popover" popover aria-labelledby="delete-3-title">
                <div class="popover-top">
                    <h2 id="delete-3-title">Delete this record?</h2><button class="icon-btn" popovertarget="delete-3"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <p>Confirm removal of the selected record. No data is deleted in this static preview.</p>
                <div class="flex" style="margin-top:18px"><button class="btn" type="button"
                        popovertarget="preview">Delete record</button><button class="btn secondary"
                        popovertarget="delete-3" popovertargetaction="hide">Keep record</button></div>
            </section>
            <section id="view-4" class="popover" popover aria-labelledby="view-4-title">
                <div class="popover-top">
                    <h2 id="view-4-title">Products / Record 5</h2><button class="icon-btn" popovertarget="view-4"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Product</span><span>
                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/decor.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt=""><span>The Desk
                                Garden</span></div>
                    </span></div>
                <div class="summary-row"><span>Category</span><span>Decor</span></div>
                <div class="summary-row"><span>Price</span><span>14.00 JOD</span></div>
                <div class="summary-row"><span>Stock</span><span>12</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-4" class="popover" popover aria-labelledby="edit-4-title">
                <div class="popover-top">
                    <h2 id="edit-4-title">Edit record</h2><button class="icon-btn" popovertarget="edit-4"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-4-name">Product name</label><input id="edit-4-name"
                        name="edit-4-name" type="text" value="The Desk Garden"></div>
                <div class="form-grid">
                    <div class="field"><label for="edit-4-cat">Category</label><select id="edit-4-cat"
                            name="edit-4-cat">
                            <option>Plants</option>
                            <option>Pots</option>
                            <option>Soil &amp; nutrition</option>
                            <option>Tools</option>
                            <option>Decor</option>
                            <option>Care &amp; treatments</option>
                        </select></div>
                    <div class="field"><label for="edit-4-price">Price (JOD)</label><input id="edit-4-price"
                            name="edit-4-price" type="number" value="14"></div>
                    <div class="field"><label for="edit-4-stock">Stock</label><input id="edit-4-stock"
                            name="edit-4-stock" type="number" value="12"></div>
                    <div class="field"><label for="edit-4-status">Status</label><select id="edit-4-status"
                            name="edit-4-status">
                            <option>Active</option>
                            <option>Draft</option>
                            <option>Under review</option>
                            <option>Rejected</option>
                        </select></div>
                </div>
                <div class="field"><label for="edit-4-image">Product image</label><input id="edit-4-image"
                        name="edit-4-image" type="file" value=""></div>
                <div class="field"><label for="edit-4-description">Description / verified label details</label><textarea
                        id="edit-4-description" rows="2"></textarea></div><button class="btn" type="button"
                    popovertarget="preview">Save changes</button>
            </section>
            <section id="delete-4" class="popover" popover aria-labelledby="delete-4-title">
                <div class="popover-top">
                    <h2 id="delete-4-title">Delete this record?</h2><button class="icon-btn" popovertarget="delete-4"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <p>Confirm removal of the selected record. No data is deleted in this static preview.</p>
                <div class="flex" style="margin-top:18px"><button class="btn" type="button"
                        popovertarget="preview">Delete record</button><button class="btn secondary"
                        popovertarget="delete-4" popovertargetaction="hide">Keep record</button></div>
            </section>
            <section id="view-5" class="popover" popover aria-labelledby="view-5-title">
                <div class="popover-top">
                    <h2 id="view-5-title">Products / Record 6</h2><button class="icon-btn" popovertarget="view-5"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Product</span><span>
                        <div class="table-product"><img src="<?= htmlspecialchars(nabta_public_url('assets/img/care.jpg'), ENT_QUOTES, 'UTF-8') ?>" alt=""><span>Leaf-care
                                Treatment</span></div>
                    </span></div>
                <div class="summary-row"><span>Category</span><span>Care &amp; treatments</span></div>
                <div class="summary-row"><span>Price</span><span>12.00 JOD</span></div>
                <div class="summary-row"><span>Stock</span><span>9</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-5" class="popover" popover aria-labelledby="edit-5-title">
                <div class="popover-top">
                    <h2 id="edit-5-title">Edit record</h2><button class="icon-btn" popovertarget="edit-5"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-5-name">Product name</label><input id="edit-5-name"
                        name="edit-5-name" type="text" value="Leaf-care Treatment"></div>
                <div class="form-grid">
                    <div class="field"><label for="edit-5-cat">Category</label><select id="edit-5-cat"
                            name="edit-5-cat">
                            <option>Plants</option>
                            <option>Pots</option>
                            <option>Soil &amp; nutrition</option>
                            <option>Tools</option>
                            <option>Decor</option>
                            <option>Care &amp; treatments</option>
                        </select></div>
                    <div class="field"><label for="edit-5-price">Price (JOD)</label><input id="edit-5-price"
                            name="edit-5-price" type="number" value="12"></div>
                    <div class="field"><label for="edit-5-stock">Stock</label><input id="edit-5-stock"
                            name="edit-5-stock" type="number" value="9"></div>
                    <div class="field"><label for="edit-5-status">Status</label><select id="edit-5-status"
                            name="edit-5-status">
                            <option>Active</option>
                            <option>Draft</option>
                            <option>Under review</option>
                            <option>Rejected</option>
                        </select></div>
                </div>
                <div class="field"><label for="edit-5-image">Product image</label><input id="edit-5-image"
                        name="edit-5-image" type="file" value=""></div>
                <div class="field"><label for="edit-5-description">Description / verified label details</label><textarea
                        id="edit-5-description" rows="2"></textarea></div><button class="btn" type="button"
                    popovertarget="preview">Save changes</button>
            </section>
            <section id="delete-5" class="popover" popover aria-labelledby="delete-5-title">
                <div class="popover-top">
                    <h2 id="delete-5-title">Delete this record?</h2><button class="icon-btn" popovertarget="delete-5"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <p>Confirm removal of the selected record. No data is deleted in this static preview.</p>
                <div class="flex" style="margin-top:18px"><button class="btn" type="button"
                        popovertarget="preview">Delete record</button><button class="btn secondary"
                        popovertarget="delete-5" popovertargetaction="hide">Keep record</button></div>
            </section>
            <section id="add" class="popover" popover aria-labelledby="add-title">
                <div class="popover-top">
                    <h2 id="add-title">Create a record</h2><button class="icon-btn" popovertarget="add"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="new-name">Product name</label><input id="new-name" name="new-name"
                        type="text" value=""></div>
                <div class="form-grid">
                    <div class="field"><label for="new-cat">Category</label><select id="new-cat" name="new-cat">
                            <option>Plants</option>
                            <option>Pots</option>
                            <option>Soil &amp; nutrition</option>
                            <option>Tools</option>
                            <option>Decor</option>
                            <option>Care &amp; treatments</option>
                        </select></div>
                    <div class="field"><label for="new-price">Price (JOD)</label><input id="new-price" name="new-price"
                            type="number" value=""></div>
                    <div class="field"><label for="new-stock">Stock</label><input id="new-stock" name="new-stock"
                            type="number" value=""></div>
                    <div class="field"><label for="new-status">Status</label><select id="new-status" name="new-status">
                            <option>Active</option>
                            <option>Draft</option>
                            <option>Under review</option>
                            <option>Rejected</option>
                        </select></div>
                </div>
                <div class="field"><label for="new-image">Product image</label><input id="new-image" name="new-image"
                        type="file" value=""></div>
                <div class="field"><label for="new-description">Description / verified label details</label><textarea
                        id="new-description" rows="2"></textarea></div><button class="btn" type="button"
                    popovertarget="preview">Create record</button>
            </section>
            <section id="preview" class="popover" popover aria-labelledby="preview-title">
                <div class="popover-top">
                    <h2 id="preview-title">Ready for the next step.</h2><button class="icon-btn" popovertarget="preview"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <p>This action is part of the HTML &amp; CSS preview. Saving, accounts, and transactions will be
                    connected to PHP later. No information has been submitted.</p><button class="btn"
                    popovertarget="preview" popovertargetaction="hide">Got it</button>
            </section>
        </div>
    </main>
</body>

</html>