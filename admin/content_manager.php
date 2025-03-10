<?php
require_once 'admin_header.php';

// Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
    .form-section {
        margin: 20px 0;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #f9f9f9;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    main.container {
        display: flex;
        flex-direction: column;
        gap: 30px;
        margin-bottom: 30px;
    }

    .content-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #fff;
    }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php require_once 'admin_sidebar.php'; ?>

        <main class="container">
            <h1 class="text-center mt-4">Content Manager</h1>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="contentTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="events-tab" data-bs-toggle="tab" data-bs-target="#events"
                        type="button" role="tab" aria-controls="events" aria-selected="true">Events</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements"
                        type="button" role="tab" aria-controls="announcements"
                        aria-selected="false">Announcements</button>
                </li>
                <!-- Trainings tab removed -->
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-3" id="contentTabsContent">
                <div class="tab-pane fade show active" id="events" role="tabpanel" aria-labelledby="events-tab">
                    <?php include 'events_tab.php'; ?>
                </div>
                <div class="tab-pane fade" id="announcements" role="tabpanel" aria-labelledby="announcements-tab">
                    <?php include 'announcements_tab.php'; ?>
                </div>
                <!-- Trainings content removed -->
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>