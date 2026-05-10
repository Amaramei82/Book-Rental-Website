<?php
require('connection.php');
require('function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Icon -->
    <link rel="shortcut icon" href="Img/icon.png" type="image/x-icon" />
    <!-- Default CSS -->
    <link rel="stylesheet" href="css/Style.css" />
    <!-- Bootstrap -->
    <link id="theme" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome Fonts-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" />
    <!-- Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Default JS-->
    <script src="js/script.js"></script>
    <title>Home | Book Rental</title>
    
    <style>
        /* Enhanced Sidebar Styles */
        .sidebar-trigger {
            position: fixed;
            top: 80px;
            left: 20px;
            z-index: 1030;
            background: #ffffff;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: 0.2s;
            border: 1px solid #eef2ff;
        }
        .sidebar-trigger:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .sidebar-trigger i {
            font-size: 1.4rem;
            color: #2563eb;
        }
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            display: none;
            backdrop-filter: blur(2px);
        }
        .sidebar-menu {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100%;
            background: #ffffff;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            z-index: 1050;
            transition: left 0.3s ease;
            display: flex;
            flex-direction: column;
            padding: 1.5rem 0;
        }
        .sidebar-menu.open {
            left: 0;
        }
        .sidebar-header {
            padding: 0 1.5rem 1rem;
            border-bottom: 1px solid #eef2ff;
            margin-bottom: 1rem;
        }
        .sidebar-header h3 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            font-size: 1.3rem;
        }
        .sidebar-header p {
            font-size: 0.75rem;
            color: #64748b;
            margin: 0.25rem 0 0;
        }
        .sidebar-nav {
            flex: 1;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-nav li {
            margin: 0.2rem 0;
        }
        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: #334155;
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar-nav li a i {
            width: 1.5rem;
            color: #2563eb;
        }
        .sidebar-nav li a:hover {
            background: #f1f5f9;
            border-left-color: #2563eb;
            color: #1e40af;
        }
        .sidebar-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #94a3b8;
            cursor: pointer;
            transition: 0.2s;
        }
        .sidebar-close:hover {
            color: #ef4444;
            transform: rotate(90deg);
        }
        /* Dark mode */
        body.dark-mode .sidebar-trigger {
            background: #1e293b;
            border-color: #334155;
        }
        body.dark-mode .sidebar-trigger i {
            color: #60a5fa;
        }
        body.dark-mode .sidebar-menu {
            background: #1e293b;
        }
        body.dark-mode .sidebar-header {
            border-bottom-color: #334155;
        }
        body.dark-mode .sidebar-header h3 {
            color: #e2e8f0;
        }
        body.dark-mode .sidebar-header p {
            color: #94a3b8;
        }
        body.dark-mode .sidebar-nav li a {
            color: #cbd5e1;
        }
        body.dark-mode .sidebar-nav li a:hover {
            background: #0f172a;
        }
        @media (max-width: 768px) {
            .sidebar-trigger {
                top: 70px;
                left: 10px;
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar Trigger Button -->
    <div class="sidebar-trigger" id="sidebarTrigger">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Menu -->
    <div class="sidebar-menu" id="sidebarMenu">
        <button class="sidebar-close" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
        <div class="sidebar-header">
            <h3><i class="fas fa-book-open me-2"></i> Book Rental</h3>
            <p>Navigate through sections</p>
        </div>
        <ul class="sidebar-nav">
            <li>
                <a href="index.php"><i class="fas fa-home"></i> Home</a>
            </li>
            <li>
                <a href="bookCategory.php"><i class="fas fa-book"></i> Book Categories</a>
            </li>
            <li>
                <a href="contactUs.php"><i class="fas fa-envelope"></i> Contact Us</a>
            </li>
        </ul>
    </div>

    <script>
        // Sidebar toggle functionality
        const trigger = document.getElementById('sidebarTrigger');
        const menu = document.getElementById('sidebarMenu');
        const overlay = document.getElementById('sidebarOverlay');
        const closeBtn = document.getElementById('sidebarClose');

        function openSidebar() {
            menu.classList.add('open');
            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            menu.classList.remove('open');
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }

        trigger.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && menu.classList.contains('open')) {
                closeSidebar();
            }
        });
    </script>
    <br>
    <br>
</body>
</html>