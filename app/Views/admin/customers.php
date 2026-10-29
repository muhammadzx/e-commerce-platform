<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Manage customers | NABTA Botanical</title>
    <meta name="description" content="NABTA Botanical admin workspace.">
    <meta name="robots" content="noindex,nofollow">
    <meta name="theme-color" content="#c5d4b4">
    <link rel="icon" href="../../../public/assets/img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="../../../public/assets/css/shared.css">
    <link rel="stylesheet" href="../../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../../public/assets/css/canopy.css">
</head>

<body class="admin-body botanical-edition workspace-page admin-customers">
    <main id="main">
        <div class="admin-shell">
            <?php include __DIR__ . '/../layouts/admin-sidebar.html'; ?>
            <div class="admin-content">
                <div class="admin-top"><span>Workspace / Customers</span>
                    <div class="flex"><span>Nabta Botanical</span><span class="pill">Preview</span></div>
                </div>
                <div class="admin-photo-strip" role="img" aria-label="Soft-focus botanical greenhouse photograph">
                    <span>CANOPY / BOTANICAL OPERATIONS<small>GROWTH · STOCK · CUSTOMER CARE</small></span>
                </div>
                <div class="admin-title">
                    <div>
                        <h1>Customers</h1>
                        <p>Meet the people growing with Nabta.</p>
                    </div><button class="btn" popovertarget="add">+ Add new</button>
                </div>
                <section class="panel">
                    <div class="toolbar"><label class="sr-only" for="search-records">Search customers</label><input
                            class="control" id="search-records" type="search" placeholder="Search customers"><button
                            class="btn secondary" popovertarget="preview">Search <svg class="icon" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <circle cx="10" cy="10" r="6"></circle>
                                <path d="m15 15 5 5"></path>
                            </svg></button><span class="label">3 records</span></div>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="Customer">Alex Morgan</td>
                                    <td data-label="Email">alex@example.com</td>
                                    <td data-label="Role">Regular user</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-0">View</button><button class="table-button"
                                                popovertarget="edit-0">Edit</button><button class="table-button"
                                                popovertarget="delete-0">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Customer">Sam Taylor</td>
                                    <td data-label="Email">sam@example.com</td>
                                    <td data-label="Role">Regular user</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-1">View</button><button class="table-button"
                                                popovertarget="edit-1">Edit</button><button class="table-button"
                                                popovertarget="delete-1">Delete</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td data-label="Customer">Jordan Lee</td>
                                    <td data-label="Email">jordan@example.com</td>
                                    <td data-label="Role">Admin</td>
                                    <td data-label="Status"><span class="pill">Active</span></td>
                                    <td data-label="Actions">
                                        <div class="table-actions"><button class="table-button"
                                                popovertarget="view-2">View</button><button class="table-button"
                                                popovertarget="edit-2">Edit</button><button class="table-button"
                                                popovertarget="delete-2">Delete</button></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

            <!-- Record 1: Alex Morgan -->
            <section id="view-0" class="popover" popover aria-labelledby="view-0-title">
                <div class="popover-top">
                    <h2 id="view-0-title">Customers / Record 1</h2><button class="icon-btn" popovertarget="view-0"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Customer</span><span>Alex Morgan</span></div>
                <div class="summary-row"><span>Email</span><span>alex@example.com</span></div>
                <div class="summary-row"><span>Role</span><span>Regular user</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-0" class="popover" popover aria-labelledby="edit-0-title">
                <div class="popover-top">
                    <h2 id="edit-0-title">Edit record</h2><button class="icon-btn" popovertarget="edit-0"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-0-name">Full name</label><input id="edit-0-name" name="edit-0-name"
                        type="text" value="Alex Morgan"></div>
                <div class="field"><label for="edit-0-email">Email</label><input id="edit-0-email" name="edit-0-email"
                        type="email" value="alex@example.com"></div>
                <div class="form-grid">
                    <div class="field"><label for="edit-0-role">Role</label><select id="edit-0-role" name="edit-0-role">
                            <option>Regular user</option>
                            <option>Admin</option>
                        </select></div>
                    <div class="field"><label for="edit-0-status">Status</label><select id="edit-0-status"
                            name="edit-0-status">
                            <option>Active</option>
                            <option>Suspended</option>
                        </select></div>
                </div>
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

            <!-- Record 2: Sam Taylor -->
            <section id="view-1" class="popover" popover aria-labelledby="view-1-title">
                <div class="popover-top">
                    <h2 id="view-1-title">Customers / Record 2</h2><button class="icon-btn" popovertarget="view-1"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Customer</span><span>Sam Taylor</span></div>
                <div class="summary-row"><span>Email</span><span>sam@example.com</span></div>
                <div class="summary-row"><span>Role</span><span>Regular user</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-1" class="popover" popover aria-labelledby="edit-1-title">
                <div class="popover-top">
                    <h2 id="edit-1-title">Edit record</h2><button class="icon-btn" popovertarget="edit-1"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-1-name">Full name</label><input id="edit-1-name" name="edit-1-name"
                        type="text" value="Sam Taylor"></div>
                <div class="field"><label for="edit-1-email">Email</label><input id="edit-1-email" name="edit-1-email"
                        type="email" value="sam@example.com"></div>
                <div class="form-grid">
                    <div class="field"><label for="edit-1-role">Role</label><select id="edit-1-role" name="edit-1-role">
                            <option>Regular user</option>
                            <option>Admin</option>
                        </select></div>
                    <div class="field"><label for="edit-1-status">Status</label><select id="edit-1-status"
                            name="edit-1-status">
                            <option>Active</option>
                            <option>Suspended</option>
                        </select></div>
                </div>
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

            <!-- Record 3: Jordan Lee -->
            <section id="view-2" class="popover" popover aria-labelledby="view-2-title">
                <div class="popover-top">
                    <h2 id="view-2-title">Customers / Record 3</h2><button class="icon-btn" popovertarget="view-2"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="summary-row"><span>Customer</span><span>Jordan Lee</span></div>
                <div class="summary-row"><span>Email</span><span>jordan@example.com</span></div>
                <div class="summary-row"><span>Role</span><span>Admin</span></div>
                <div class="summary-row"><span>Status</span><span><span class="pill">Active</span></span></div>
            </section>
            <section id="edit-2" class="popover" popover aria-labelledby="edit-2-title">
                <div class="popover-top">
                    <h2 id="edit-2-title">Edit record</h2><button class="icon-btn" popovertarget="edit-2"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="edit-2-name">Full name</label><input id="edit-2-name" name="edit-2-name"
                        type="text" value="Jordan Lee"></div>
                <div class="field"><label for="edit-2-email">Email</label><input id="edit-2-email" name="edit-2-email"
                        type="email" value="jordan@example.com"></div>
                <div class="form-grid">
                    <div class="field"><label for="edit-2-role">Role</label><select id="edit-2-role" name="edit-2-role">
                            <option>Regular user</option>
                            <option selected>Admin</option>
                        </select></div>
                    <div class="field"><label for="edit-2-status">Status</label><select id="edit-2-status"
                            name="edit-2-status">
                            <option>Active</option>
                            <option>Suspended</option>
                        </select></div>
                </div>
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

            <!-- Add new -->
            <section id="add" class="popover" popover aria-labelledby="add-title">
                <div class="popover-top">
                    <h2 id="add-title">Create a record</h2><button class="icon-btn" popovertarget="add"
                        popovertargetaction="hide" aria-label="Close window">×</button>
                </div>
                <div class="field"><label for="new-name">Full name</label><input id="new-name" name="new-name"
                        type="text" value=""></div>
                <div class="field"><label for="new-email">Email</label><input id="new-email" name="new-email"
                        type="email" value=""></div>
                <div class="form-grid">
                    <div class="field"><label for="new-role">Role</label><select id="new-role" name="new-role">
                            <option>Regular user</option>
                            <option>Admin</option>
                        </select></div>
                    <div class="field"><label for="new-status">Status</label><select id="new-status" name="new-status">
                            <option>Active</option>
                            <option>Suspended</option>
                        </select></div>
                </div>
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