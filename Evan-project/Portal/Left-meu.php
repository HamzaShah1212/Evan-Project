<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// agar login nahi hai to redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Evan Vista</title>
    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #4A90E2;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
            --text-light: #ecf0f1;
            --text-muted: #bdc3c7;
            --transition: all 0.3s ease;
        }
        
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: var(--text-light);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1001;
            box-shadow: 2px 0 20px rgba(0,0,0,0.2);
            overflow-y: auto;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: none;
            will-change: transform;
        }
        
        .user-info {
            padding: 25px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .user-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin: 0 auto 15px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #fff;
        }
        
        .user-name {
            font-size: 16px;
            font-weight: 600;
            margin: 5px 0 0;
            color: #fff;
        }
        
        .user-role {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
        }
        
        .nav-menu {
            padding: 15px 0;
        }
        
        .menu-title {
            padding: 10px 20px;
            font-size: 11px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }
        
        .nav-menu ul {
            list-style: none;
            padding: 0 10px;
            margin: 0 0 15px 0;
        }
        
        .nav-menu li {
            margin: 2px 0;
        }
        
        .nav-menu a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 5px;
            transition: var(--transition);
            font-size: 14px;
            font-weight: 500;
        }
        
        .nav-menu a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            font-size: 16px;
        }
        
        .nav-menu a:hover, 
        .nav-menu a.active {
            background: var(--primary-color);
            color: #fff;
            transform: translateX(5px);
        }
        
        .nav-menu a.text-danger:hover {
            background: #e74c3c;
            color: #fff !important;
        }
        
        .nav-menu a .badge {
            margin-left: auto;
            background: rgba(255,255,255,0.2);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 500;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 25px;
            min-height: 100vh;
            transition: margin 0.3s ease;
        }
        
        /* Table Styling */
        .content h1 {
            color: #333;
            margin-bottom: 25px;
            font-size: 24px;
            font-weight: 600;
        }
        
        table {
            width: 100%;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        table thead th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            padding: 15px 20px;
            text-align: left;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        table tbody td {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
            font-size: 14px;
        }
        
        table tbody tr:last-child td {
            border-bottom: none;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        table tbody tr:hover {
            background-color: #f1f5ff;
        }
        
        /* Responsive */
        /* Offcanvas for mobile */
        /* Modern Mobile Menu Toggle Button */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1002;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        
        .menu-toggle span {
            font-size: 24px;
            line-height: 1;
        }
        
        .menu-toggle:hover {
            background: #3a7bc8;
            transform: scale(1.1);
        }
        
        /* Modern Close Button */
        .close-sidebar {
            display: none;
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255,255,255,0.1);
            border: none;
            color: var(--text-light);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 1003;
        }
        
        .close-sidebar:hover {
            background: rgba(255,255,255,0.2);
            transform: rotate(90deg);
        }
        
        @media (max-width: 991.98px) {
            .close-sidebar {
                display: flex;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
        
        @media (min-width: 992px) {
            .menu-toggle {
                display: none;
            }
            
            .close-sidebar {
                display: none !important;
            }
            
            .sidebar-overlay {
                display: none !important;
            }
        }
        
        @media (max-width: 991.98px) {
            .menu-toggle {
                display: flex;
            }
            
            body {
                padding-left: 0;
                transition: padding-left 0.3s ease-in-out;
            }
            
            .sidebar {
                width: 85%;
                max-width: 300px;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .sidebar.show {
                transform: translateX(0);
                display: block;
                position: fixed;
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1000;
                opacity: 0;
                transition: opacity 0.3s ease-in-out;
            }
            
            .sidebar.show + .sidebar-overlay {
                display: block;
                opacity: 1;
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 0;
            }
            
            .nav-link {
                padding: 0.75rem 1.5rem;
            }
            
            .nav-item {
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            
            .nav-item:last-child {
                border-bottom: none;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const closeSidebar = document.getElementById('closeSidebar');
            
            // Toggle sidebar when menu button is clicked
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }
            
            menuToggle.addEventListener('click', toggleSidebar);
            closeSidebar.addEventListener('click', toggleSidebar);
            
            // Close sidebar when clicking on overlay
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                document.body.style.overflow = '';
            });
            
            // Close sidebar when clicking on a menu item (for single page applications)
            const menuItems = document.querySelectorAll('.nav-menu a');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    document.body.style.overflow = '';
                });
            });
            
            // Close sidebar when window is resized to desktop view
            function handleResize() {
                if (window.innerWidth > 991.98) {
                    sidebar.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }
            
            window.addEventListener('resize', handleResize);
        });
    </script>
</head>
<body>
    <!-- Mobile Menu Toggle Button -->
    <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu">
        <span>☰</span>
    </button>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Close Button -->
        <button class="close-sidebar" id="closeSidebar" aria-label="Close menu">
            &times;
        </button>
        <div class="user-info text-center p-4">
            <div class="user-avatar mb-2">
                <i class="fas fa-user"></i>
            </div>
            <h5 class="user-name"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?></h5>
            <small class="user-role"><?php echo htmlspecialchars($_SESSION['user_role'] ?? 'Administrator'); ?></small>
        </div>
        
        <nav class="nav-menu">
            <div class="menu-title">MAIN</div>
            <ul>
                <li>
                    <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
            </ul>
            
            <div class="menu-title mt-4">MANAGEMENT</div>
            <ul>
                <li>
                    <a href="customers.php" class="<?= basename($_SERVER['PHP_SELF']) == 'customers.php' ? 'active' : '' ?>">
                        <i class="fas fa-users"></i> Customers
                    </a>
                </li>
                <li>
                    <a href="projects.php" class="<?= basename($_SERVER['PHP_SELF']) == 'projects.php' ? 'active' : '' ?>">
                        <i class="fas fa-project-diagram"></i> Projects
                    </a>
                </li>
                <li>
                    <a href="states.php" class="<?= basename($_SERVER['PHP_SELF']) == 'states.php' ? 'active' : '' ?>">
                        <i class="fas fa-map-marked-alt"></i> States
                    </a>
                </li>
                <li>
                    <a href="cities.php" class="<?= basename($_SERVER['PHP_SELF']) == 'cities.php' ? 'active' : '' ?>">
                        <i class="fas fa-city"></i> Cities
                    </a>
                </li>
            </ul>
            
            <div class="menu-title mt-4">COMMUNICATION</div>
            <ul>
                <li>
                    <a href="Customer-Contact.php" class="<?= basename($_SERVER['PHP_SELF']) == 'Customer-Contact.php' ? 'active' : '' ?>">
                        <i class="fas fa-envelope"></i> Contact Messages
                        <span class="badge bg-danger">New</span>
                    </a>
                </li>
            </ul>
            
            <div class="menu-title mt-4">PREFERENCES</div>
            <ul>
                <li>
                    <a href="settings.php" class="<?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    
</body>
</html>
