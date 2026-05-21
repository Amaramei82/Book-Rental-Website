<?php
require('connection.php');
require('function.php');
require('api_check.php');
if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN'] != ' ') {
} else {
    header('location:login.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Admin Panel</title>
    <!-- Icon -->
    <link rel="shortcut icon" href="../Img/icon.png" type="image/x-icon" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="css/mdb.min.css" />
    <!-- Custom styles for enhanced design -->
    <style>
        /* Enhanced Admin Navbar Styles */
        body {
            background: #f4f6f9;
            font-family: 'Roboto', sans-serif;
        }
        .navbar-enhanced {
            background: linear-gradient(135deg, #0f172a, #1e293b) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 0.6rem 1rem;
        }
        .navbar-enhanced .navbar-brand img {
            transition: transform 0.2s;
        }
        .navbar-enhanced .navbar-brand:hover img {
            transform: scale(1.02);
        }
        .navbar-enhanced .navbar-nav .nav-link {
            color: #e2e8f0 !important;
            font-weight: 500;
            margin: 0 0.2rem;
            padding: 0.6rem 1rem;
            border-radius: 2rem;
            transition: all 0.25s ease;
        }
        .navbar-enhanced .navbar-nav .nav-link:hover,
        .navbar-enhanced .navbar-nav .nav-link:focus {
            background: rgba(255, 255, 255, 0.12);
            color: white !important;
            transform: translateY(-1px);
        }
        /* Active link highlight (based on current URL path) */
        .navbar-enhanced .navbar-nav .nav-link.active {
            background: #2563eb;
            color: white !important;
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }
        /* Dropdown button styling */
        .btn-admin-dropdown {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 2rem;
            padding: 0.4rem 1rem;
            color: white;
            font-weight: 500;
            transition: 0.2s;
        }
        .btn-admin-dropdown:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }
        .dropdown-menu-enhanced {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
            padding: 0.5rem 0;
        }
        .dropdown-menu-enhanced .dropdown-item {
            padding: 0.5rem 1.2rem;
            font-weight: 500;
            transition: 0.2s;
        }
        .dropdown-menu-enhanced .dropdown-item:hover {
            background: #f1f5f9;
            padding-left: 1.5rem;
        }
        /* Navbar toggler icon */
        .navbar-toggler-custom {
            border: none;
            background: transparent;
            color: white;
            font-size: 1.5rem;
        }
        .navbar-toggler-custom:focus {
            box-shadow: none;
        }
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .navbar-enhanced .navbar-nav .nav-link {
                margin: 0.2rem 0;
                display: inline-block;
            }
            .btn-admin-dropdown {
                margin-top: 0.5rem;
                width: fit-content;
            }
        }
        /* Brand logo area subtle glow */
        .brand-glow {
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-enhanced">
        <div class="container-fluid">
            <button class="navbar-toggler navbar-toggler-custom" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="navbar-brand" href="categories.php">
                    <img src="../Img/logo.png" height="34" alt="Book Rental Admin" class="brand-glow" />
                </a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.php">Books list</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="orders.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a href="returnDate.php" class="nav-link">Return Date</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="feedback.php">Feedbacks</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
                <?php
                $userName = $_SESSION['ADMIN_email'];
                echo '<div class="dropdown">
                            <button class="btn btn-admin-dropdown dropdown-toggle" type="button" id="adminDropdown" data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>' . htmlspecialchars($userName) . '
                            </button>
                            <ul class="dropdown-menu dropdown-menu-enhanced dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>';
                ?>
            </div>
        </div>
    </nav>

    <!-- Script to set active nav link based on current URL (optional enhancement) -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const currentPath = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>