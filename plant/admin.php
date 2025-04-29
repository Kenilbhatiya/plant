<?php
include 'admin_session_check.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plants_nursery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch statistics
$stats = array(
    'total_sales' => 0,
    'total_orders' => 0,
    'total_products' => 0,
    'total_users' => 0
);

// Get total sales
$result = $conn->query("SELECT SUM(amount) as total FROM orders");
if ($result && $row = $result->fetch_assoc()) {
    $stats['total_sales'] = $row['total'] ?? 0;
}

// Get total orders
$result = $conn->query("SELECT COUNT(*) as total FROM orders");
if ($result && $row = $result->fetch_assoc()) {
    $stats['total_orders'] = $row['total'];
}

// Get total products
$result = $conn->query("SELECT COUNT(*) as total FROM products");
if ($result && $row = $result->fetch_assoc()) {
    $stats['total_products'] = $row['total'];
}

// Get total users
$result = $conn->query("SELECT COUNT(*) as total FROM users");
if ($result && $row = $result->fetch_assoc()) {
    $stats['total_users'] = $row['total'];
}

// Get recent orders
$recent_orders = array();
$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC LIMIT 5");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recent_orders[] = $row;
    }
}

// Get products
$products = array();
$result = $conn->query("SELECT * FROM products ORDER BY product_id DESC LIMIT 5");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Get users
$users = array();
$result = $conn->query("SELECT * FROM users ORDER BY join_date DESC LIMIT 5");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Plants Nursery</title>
    <link rel="shortcut icon" type="image" href="logo3.jpg">
    <link rel="stylesheet" href="Homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .admin-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 23%;
            text-align: center;
        }

        .stat-card h3 {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .admin-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .admin-section h2 {
            color: #4CAF50;
            margin-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th, .admin-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .admin-table th {
            background-color: #f8f9fa;
            color: #4CAF50;
        }

        .admin-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .admin-btn:hover {
            background: #45a049;
        }

        .status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-processing {
            background: #cce5ff;
            color: #004085;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-bar input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
        }

        .admin-welcome {
            text-align: right;
            margin-bottom: 20px;
            color: #666;
        }
        
        .admin-welcome span {
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <div class="title">
                <a href="Homepage.html">Plants Nursery</a>
            </div>
            <nav>
                <ul>
                    <li><a href="admin.php" class="active">Admin Dashboard</a></li>
                    <li><a href="admin_logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="admin-container">
        <div class="admin-welcome">
            Welcome, <span><?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
        </div>
        <div class="admin-header">
            <h1>Admin Dashboard</h1>
        </div>

        <div class="admin-stats">
            <div class="stat-card">
                <h3>₹<?php echo number_format($stats['total_sales'], 2); ?></h3>
                <p>Total Sales</p>
            </div>
            <div class="stat-card">
                <h3><?php echo number_format($stats['total_orders']); ?></h3>
                <p>Total Orders</p>
            </div>
            <div class="stat-card">
                <h3><?php echo number_format($stats['total_products']); ?></h3>
                <p>Total Products</p>
            </div>
            <div class="stat-card">
                <h3><?php echo number_format($stats['total_users']); ?></h3>
                <p>Total Users</p>
            </div>
        </div>

        <div class="admin-section">
            <div class="search-bar">
                <h2>Recent Orders</h2>
                <input type="text" placeholder="Search orders...">
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_orders as $order): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($order['order_date'])); ?></td>
                        <td>₹<?php echo number_format($order['amount'], 2); ?></td>
                        <td>
                            <span class="status status-<?php echo strtolower($order['status']); ?>">
                                <?php echo htmlspecialchars($order['status']); ?>
                            </span>
                        </td>
                        <td><button class="admin-btn">View</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <div class="search-bar">
                <h2>Product Management</h2>
                <button class="admin-btn"><a href="add_product.php">Add New Product</a></button>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($product['product_id']); ?></td>
                        <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($product['product_category']); ?></td>
                        <td><?php echo htmlspecialchars($product['product_description']); ?></td>
                        <td>₹<?php echo number_format($product['product_price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($product['product_stock']); ?></td>
                        <td><?php echo htmlspecialchars($product['product_image']); ?></td>
                        <td><button class="admin-btn">Edit</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <div class="search-bar">
                <h2>User Management</h2>
                <input type="text" placeholder="Search users...">
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Join Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($user['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($user['join_date'])); ?></td>
                        <td><?php echo htmlspecialchars($user['status']); ?></td>
                        <td><button class="admin-btn">Manage</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <div class="BackToTop"><center><a href="admin.php"> BACK TO TOP </a></center></div>
        <div class="main-content">
            <div class="left box">
                <h2>About us</h2>
                <div class="content">
                    <p>Plants Nursery Admin Dashboard</p>
                    <p>Manage your plant nursery business efficiently</p>
                    <div class="social">
                        <a href="http://facebook.com/" target="_blank"><span class="fa fa-facebook"></span></a>
                        <a href="http://twitter.com" target="_blank"><span class="fa fa-twitter"></span></a>
                        <a href="http://instagram.com/1rithik1" target="_blank"><span class="fa fa-instagram"></span></a>
                        <a href="http://linkedin.com" target="_blank"><span class="fa fa-linkedin"></span></a>
                    </div>
                </div>
            </div>
            <div class="center box">
                <h2>Address</h2>
                <div class="content">
                    <div class="place">
                        <span class="fa fa-map-marker">&nbsp;</span>
                        <span class="text"> Worli, Mumbai, Maharashtra, India </span>
                    </div>
                    <br>
                    <div class="phone">
                        <span class="fa fa-phone">&nbsp;</span>
                        <span class="text"> +91 9004565911 </span>
                    </div>
                    <br>
                    <div class="email">
                        <span class="fa fa-envelope">&nbsp;</span>
                        <span class="text"> swargam.rithik.19bit052@gmail.com </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom">
            <center>
                <span class="credit">Created By Rithik Swargam</span>
                <span class="fa fa-copyright"></span><span> 2024 All rights reserved.</span>
            </center>
        </div>
    </footer>
</body>
</html> 