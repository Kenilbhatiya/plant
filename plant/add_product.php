<?php
include 'admin_session_check.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'config.php';
    
    $pid = $_POST['product_id'];
    $pname = $_POST['product_name'];
    $pcategory = $_POST['product_category'];
    $pdescription = $_POST['product_description'];
    $pprice = $_POST[' product_price'];
    $pstock = $_POST[' product_stock'];
    $pimage = $_POST['product_image'];
    
    // Create uploads directory if it doesn't exist
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }
    
    // Move uploaded file
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($image_tmp, $target_file);
    
    // Insert into database
    $sql = "INSERT INTO products (product_id,product_name,product_category,product_description,product_price, product_stock, product_image) 
            VALUES ('$pid', '$pname', '$pcategory', '$pdescription', '$pprice', '$pstock', '$pimage')";
    
    if (mysqli_query($con, $sql)) {
        header("Location: admin.html?success=1");
        exit();
    } else {
        $error = "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Product - Plants Nursery</title>
    <link rel="shortcut icon" type="image" href="logo3.jpg">
    <link rel="stylesheet" href="Homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .admin-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-header {
            text-align: center;
            margin-bottom: 75px;
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-weight: bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group textarea {
            height: 100px;
            resize: vertical;
        }

        .admin-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        .admin-btn:hover {
            background: #45a049;
        }

        .error {
            color: #dc3545;
            margin-bottom: 20px;
            padding: 10px;
            background: #f8d7da;
            border-radius: 5px;
        }

        .success {
            color: #28a745;
            margin-bottom: 20px;
            padding: 10px;
            background: #d4edda;
            border-radius: 5px;
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
                    <li><a href="admin.html">Admin Dashboard</a></li>
                    <li><a href="admin_login.html">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="admin-container">
        <div class="admin-header">
            <h1>Add New Product</h1>
        </div>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="admin-section">
            <form action="add_product.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Indoor Plants">Indoor Plants</option>
                        <option value="Outdoor Plants">Outdoor Plants</option>
                        <option value="Flowering Plants">Flowering Plants</option>
                        <option value="Medicinal Plants">Medicinal Plants</option>
                        <option value="Fruit Plants">Fruit Plants</option>
                        <option value="Sacred Plants">Sacred Plants</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Price (₹)</label>
                    <input type="number" id="price" name="price" min="0" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock Quantity</label>
                    <input type="number" id="stock" name="stock" min="0" required>
                </div>

                <div class="form-group">
                    <label for="description">Product Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="product_image">Product Image</label>
                    <input type="file" id="product_image" name="product_image" accept="image/*" required>
                </div>

                <button type="submit" class="admin-btn">Add Product</button>
                <a href="admin.html" class="admin-btn" style="background: #6c757d; margin-left: 10px;">Cancel</a>
            </form>
        </div>
    </div>

    <footer>
        <div class="BackToTop"><center><a href="admin.html"> BACK TO TOP </a></center></div>
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