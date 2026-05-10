<?php
require('Admin\connection.php');
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
    <link rel="stylesheet" href="css/responsive.css" />
    <link rel="stylesheet" href="css/darkMode.css" />
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
        /* Enhanced Header Styles - Design Only */
        .navbar-enhanced {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 0.6rem 1rem;
            transition: all 0.3s;
        }
        .navbar-brand img {
            transition: transform 0.2s;
        }
        .navbar-brand:hover img {
            transform: scale(1.02);
        }
        .navbar-nav .nav-link {
            font-weight: 500;
            margin: 0 0.2rem;
            padding: 0.6rem 1rem;
            border-radius: 2rem;
            transition: all 0.25s ease;
            color: #e2e8f0 !important;
        }
        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateY(-1px);
        }
        .navbar-nav .nav-link i {
            margin-right: 6px;
        }
        /* Search bar styling */
        #searchBar {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3rem;
            padding: 0.2rem 0.2rem 0.2rem 1rem;
            backdrop-filter: blur(2px);
            transition: 0.2s;
        }
        #searchBar:focus-within {
            background: rgba(255, 255, 255, 0.2);
        }
        #searchBar .form-control {
            background: transparent;
            border: none;
            color: white;
            outline: none;
            box-shadow: none;
            width: 200px;
        }
        #searchBar .form-control::placeholder {
            color: #cbd5e1;
            font-size: 0.85rem;
        }
        #searchBar .search-btn {
            background: #3b82f6;
            border-radius: 2rem;
            padding: 0.3rem 1rem;
            transition: 0.2s;
        }
        #searchBar .search-btn:hover {
            background: #2563eb;
            transform: scale(0.98);
        }
        /* Login button */
        .login-btn {
            border-radius: 2rem !important;
            padding: 0.4rem 1.2rem !important;
            font-weight: 500 !important;
            transition: 0.2s !important;
            border: 1px solid #3b82f6 !important;
            background: transparent !important;
            color: #e2e8f0 !important;
        }
        .login-btn:hover {
            background: #3b82f6 !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(59,130,246,0.3);
        }
        /* Dropdown menu (user profile) */
        .dropdown-menu.bg-dark {
            background: #1e293b !important;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 12px 24px rgba(0,0,0,0.2);
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }
        .dropdown-item-text {
            padding: 0.5rem 1.2rem;
            display: block;
            transition: 0.2s;
            color: #cbd5e1 !important;
        }
        .dropdown-item-text:hover {
            background: #334155;
            color: white !important;
            padding-left: 1.5rem;
        }
        hr.bg-white {
            opacity: 0.2;
            margin: 0.3rem 1rem;
        }
        /* Navbar toggler icon */
        .navbar-toggler {
            border: none;
            background: transparent;
        }
        .navbar-toggler:focus {
            box-shadow: none;
        }
        /* Responsive adjustments */
        @media (max-width: 992px) {
            .navbar-nav .nav-link {
                margin: 0.2rem 0;
            }
            #searchBar {
                margin: 0.5rem 1rem;
                background: rgba(0,0,0,0.2);
            }
            .login-btn {
                margin: 0.5rem 1rem !important;
                display: inline-block;
                width: auto;
            }
        }
        /* Additional small details */
        .navbar-nav .nav-link.active {
            background: rgba(59,130,246,0.2);
            color: #60a5fa !important;
        }
        body {
            padding-top: 70px; /* compensate fixed navbar */
        }
        @media (max-width: 768px) {
            body {
                padding-top: 60px;
            }
        }
    </style>
</head>

<body>
    <section id="#navbar">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow lh-1 navbar-enhanced">
            <a class="navbar-brand img-fluid ms-2" href="index.php">
                <img src="Img/logo.png" alt="logo" height="40vw" />
            </a>
            <button class="navbar-toggler" title="Menu" type="button" data-bs-toggle="collapse"
                data-bs-target="#mynavbar">
                <span style="font-size: 1.8465rem; color: #fff">
                    <i class="fas fa-bars"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav navbar me-auto">
                    <li class="nav-item">
                        <a id="#home" class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="bookCategory.php"><i class="fas fa-book"></i> Book Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactUs.php"><i class="fas fa-envelope"></i> Contact Us</a>
                    </li>
                    <?php
                    if (isset($_SESSION['USER_LOGIN'])) {
                        echo '<li class="nav-item">
                    <a class="nav-link" href="myOrder.php"><i class="fas fa-shopping-bag"></i> My Orders</a>
                </li>';
                    }
                    ?>
                </ul>
                <form method="get" action="search.php" class="d-flex" id="searchBar">
                    <input class="form-control" type="text" name="search" placeholder="Search by Title or Author..." />
                    <button title="Search" class="btn text-white search-btn me-1" type="submit" name="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="navbar-nav navbar">
                    <?php
                    if (isset($_SESSION['USER_LOGIN'])) {
                        $userName = $_SESSION['USER_NAME'];
                        echo '<ul class="navbar-nav navb me-4">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                ><i class="fas fa-user-circle me-1"></i>' . htmlspecialchars($userName) . '</a>
                                <ul class="dropdown-menu bg-dark">
                                    <li>
                                        <a class="dropdown-item-text text-white-50 text-decoration-none" href="profile.php"><i class="fas fa-user-edit me-2"></i> Edit Profile</a>
                                    </li>
                                    <hr class="bg-white m-2">
                                    <li><a class="dropdown-item-text text-white-50 text-decoration-none" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>';
                    } else {
                        echo '<a class="text-decoration-none me-1 ms-3 text-white btn-dark btn btn-outline-light me-2 login-btn"
                           role="button" href="SignIn.php"><i class="fas fa-sign-in-alt me-1"></i> Login</a>';
                    }
                    ?>
                </div>
            </div>
        </nav>
    </section>
    <br>
    <br>