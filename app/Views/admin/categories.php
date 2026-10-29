<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Manage categories | NABTA Botanical</title>
    <meta name="description" content="NABTA Botanical admin workspace.">
    <meta name="robots" content="noindex,nofollow">
    <meta name="theme-color" content="#c5d4b4">
    <link rel="icon" href="../../../public/assets/img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="../../../public/assets/css/shared.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../../public/assets/css/canopy.css">
</head>

<body class="admin-body botanical-edition workspace-page admin-categories">
    <main id="main">
        <div class="admin-shell">
            <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>
            <div class="admin-content">
                <div class="admin-top"><span>Workspace / Categories</span>
                    <div class="flex"><span>Nabta Botanical</span><span class="pill">Preview</span></div>
                </div>
                <div class="admin-photo-strip" role="img" aria-label="Soft-focus botanical greenhouse photograph">
                    <span>CANOPY / BOTANICAL OPERATIONS<small>GROWTH · STOCK · CUSTOMER CARE</small></span>
                </div>
                <div class="admin-title">
                    <div>
                        <h1>Categories</h1>
                        <p>A clear place for every growing essential.</p>
                    </div><button class="btn" popovertarget="add">+ Add new</button>
                </div>
                <section class="panel">
                    <div class="toolbar"><label class="sr-only" for="search-records">Search categories</label><input
                            class="control" id="search-records" type="search" placeholder="Search categories"><button
                            class="btn secondary" popovertarget="preview">Search <svg class="icon" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <circle cx="10" cy="10" r="6"></circle>
                                <path d="m15 15 5 5"></path>
                            </svg></button><span class="label">6 records</span></div>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Category">Plants</td>
                                    <td data-label="Description">Indoor &amp; outdoor plants</td>
                                    <td data-label="Products">1</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-0">View</button><button class="table-button"
                                                popovertarget="edit-0">Edit</button><button class="table-button"
                                                popovertarget="delete-0">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Category">Pots</td>
                                    <td data-label="Description">Pots, planters &amp; saucers</td>
                                    <td data-label="Products">1</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-1">View</button><button class="table-button"
                                                popovertarget="edit-1">Edit</button><button class="table-button"
                                                popovertarget="delete-1">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Category">Soil &amp; nutrition</td>
                                    <td data-label="Description">Potting mixes &amp; nutrients</td>
                                    <td data-label="Products">1</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-2">View</button><button class="table-button"
                                                popovertarget="edit-2">Edit</button><button class="table-button"
                                                popovertarget="delete-2">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Category">Tools</td>
                                    <td data-label="Description">Practical gardening tools</td>
                                    <td data-label="Products">1</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-3">View</button><button class="table-button"
                                                popovertarget="edit-3">Edit</button><button class="table-button"
                                                popovertarget="delete-3">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Category">Decor</td>
                                    <td data-label="Description">Botanical gifts &amp; objects</td>
                                    <td data-label="Products">1</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-4">View</button><button class="table-button"
                                                popovertarget="edit-4">Edit</button><button class="table-button"
                                                popovertarget="delete-4">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Category">Care &amp; treatments</td>
                                    <td data-label="Description">Plant health &amp; care products</td>
                                    <td data-label="Products">1</td>
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

            <!-- Record 1: Plants -->
            <section id="view-0" class="popover" popover aria-labelledby="view-0-title">
                <div class="popover-top">
                    <h2 id="view-0-title">Categories / Record 1</h2><button class="icon-btn" popovertarget="view-0"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Category</span><span>Plants</span></div>
                <div class="summary-row"><span>Description</span><span>Indoor &amp; outdoor plants</span></div>
                <div class="summary-row"><span>Products</span><span>1</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-0" class="popover" popover aria-labelledby="edit-0-title">
                <div class="popover-top">
                    <h2 id="edit-0-title">Edit record</h2><button class="icon-btn" popovertarget="edit-0"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-0-name">Category name</label><input id="edit-0-name"
                        name="edit-0-name" type="text" value="Plants"></div>
                <div class="field"><label for="edit-0-description">Description</label><textarea id="edit-0-description"
                        name="edit-0-description" rows="2"></textarea></div>
                <div class="field"><label for="edit-0-status">Status</label><select id="edit-0-status"
                        name="edit-0-status">
                        <option>Active</option>
                        <option>Hidden</option>
                    </select></div>
                <button class="btn" type="button" popovertarget="preview">Save changes</button>
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

            <!-- Record 2: Pots -->
            <section id="view-1" class="popover" popover aria-labelledby="view-1-title">
                <div class="popover-top">
                    <h2 id="view-1-title">Categories / Record 2</h2><button class="icon-btn" popovertarget="view-1"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Category</span><span>Pots</span></div>
                <div class="summary-row"><span>Description</span><span>Pots, planters &amp; saucers</span></div>
                <div class="summary-row"><span>Products</span><span>1</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-1" class="popover" popover aria-labelledby="edit-1-title">
                <div class="popover-top">
                    <h2 id="edit-1-title">Edit record</h2><button class="icon-btn" popovertarget="edit-1"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-1-name">Category name</label><input id="edit-1-name"
                        name="edit-1-name" type="text" value="Pots"></div>
                <div class="field"><label for="edit-1-description">Description</label><textarea id="edit-1-description"
                        name="edit-1-description" rows="2"></textarea></div>
                <div class="field"><label for="edit-1-status">Status</label><select id="edit-1-status"
                        name="edit-1-status">
                        <option>Active</option>
                        <option>Hidden</option>
                    </select></div>
                <button class="btn" type="button" popovertarget="preview">Save changes</button>
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

            <!-- Record 3: Soil & nutrition -->
            <section id="view-2" class="popover" popover aria-labelledby="view-2-title">
                <div class="popover-top">
                    <h2 id="view-2-title">Categories / Record 3</h2><button class="icon-btn" popovertarget="view-2"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Category</span><span>Soil &amp; nutrition</span></div>
                <div class="summary-row"><span>Description</span><span>Potting mixes &amp; nutrients</span></div>
                <div class="summary-row"><span>Products</span><span>1</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-2" class="popover" popover aria-labelledby="edit-2-title">
                <div class="popover-top">
                    <h2 id="edit-2-title">Edit record</h2><button class="icon-btn" popovertarget="edit-2"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-2-name">Category name</label><input id="edit-2-name"
                        name="edit-2-name" type="text" value="Soil &amp; nutrition"></div>
                <div class="field"><label for="edit-2-description">Description</label><textarea id="edit-2-description"
                        name="edit-2-description" rows="2"></textarea></div>
                <div class="field"><label for="edit-2-status">Status</label><select id="edit-2-status"
                        name="edit-2-status">
                        <option>Active</option>
                        <option>Hidden</option>
                    </select></div>
                <button class="btn" type="button" popovertarget="preview">Save changes</button>
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

            <!-- Record 4: Tools -->
            <section id="view-3" class="popover" popover aria-labelledby="view-3-title">
                <div class="popover-top">
                    <h2 id="view-3-title">Categories / Record 4</h2><button class="icon-btn" popovertarget="view-3"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Category</span><span>Tools</span></div>
                <div class="summary-row"><span>Description</span><span>Practical gardening tools</span></div>
                <div class="summary-row"><span>Products</span><span>1</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-3" class="popover" popover aria-labelledby="edit-3-title">
                <div class="popover-top">
                    <h2 id="edit-3-title">Edit record</h2><button class="icon-btn" popovertarget="edit-3"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-3-name">Category name</label><input id="edit-3-name"
                        name="edit-3-name" type="text" value="Tools"></div>
                <div class="field"><label for="edit-3-description">Description</label><textarea id="edit-3-description"
                        name="edit-3-description" rows="2"></textarea></div>
                <div class="field"><label for="edit-3-status">Status</label><select id="edit-3-status"
                        name="edit-3-status">
                        <option>Active</option>
                        <option>Hidden</option>
                    </select></div>
                <button class="btn" type="button" popovertarget="preview">Save changes</button>
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

            <!-- Record 5: Decor -->
            <section id="view-4" class="popover" popover aria-labelledby="view-4-title">
                <div class="popover-top">
                    <h2 id="view-4-title">Categories / Record 5</h2><button class="icon-btn" popovertarget="view-4"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Category</span><span>Decor</span></div>
                <div class="summary-row"><span>Description</span><span>Botanical gifts &amp; objects</span></div>
                <div class="summary-row"><span>Products</span><span>1</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-4" class="popover" popover aria-labelledby="edit-4-title">
                <div class="popover-top">
                    <h2 id="edit-4-title">Edit record</h2><button class="icon-btn" popovertarget="edit-4"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-4-name">Category name</label><input id="edit-4-name"
                        name="edit-4-name" type="text" value="Decor"></div>
                <div class="field"><label for="edit-4-description">Description</label><textarea id="edit-4-description"
                        name="edit-4-description" rows="2"></textarea></div>
                <div class="field"><label for="edit-4-status">Status</label><select id="edit-4-status"
                        name="edit-4-status">
                        <option>Active</option>
                        <option>Hidden</option>
                    </select></div>
                <button class="btn" type="button" popovertarget="preview">Save changes</button>
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

            <!-- Record 6: Care & treatments -->
            <section id="view-5" class="popover" popover aria-labelledby="view-5-title">
                <div class="popover-top">
                    <h2 id="view-5-title">Categories / Record 6</h2><button class="icon-btn" popovertarget="view-5"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Category</span><span>Care &amp; treatments</span></div>
                <div class="summary-row"><span>Description</span><span>Plant health &amp; care products</span></div>
                <div class="summary-row"><span>Products</span><span>1</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-5" class="popover" popover aria-labelledby="edit-5-title">
                <div class="popover-top">
                    <h2 id="edit-5-title">Edit record</h2><button class="icon-btn" popovertarget="edit-5"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-5-name">Category name</label><input id="edit-5-name"
                        name="edit-5-name" type="text" value="Care &amp; treatments"></div>
                <div class="field"><label for="edit-5-description">Description</label><textarea id="edit-5-description"
                        name="edit-5-description" rows="2"></textarea></div>
                <div class="field"><label for="edit-5-status">Status</label><select id="edit-5-status"
                        name="edit-5-status">
                        <option>Active</option>
                        <option>Hidden</option>
                    </select></div>
                <button class="btn" type="button" popovertarget="preview">Save changes</button>
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

            <!-- Add new -->
            <section id="add" class="popover" popover aria-labelledby="add-title">
                <div class="popover-top">
                    <h2 id="add-title">Create a record</h2><button class="icon-btn" popovertarget="add"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="new-name">Category name</label><input id="new-name" name="new-name"
                        type="text" value=""></div>
                <div class="field"><label for="new-description">Description</label><textarea id="new-description"
                        name="new-description" rows="2"></textarea></div>
                <div class="field"><label for="new-status">Status</label><select id="new-status" name="new-status">
                        <option>Active</option>
                        <option>Hidden</option>
                    </select></div>
                <button class="btn" type="button" popovertarget="preview">Create record</button>
            </section>

            <!-- Preview notice -->
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