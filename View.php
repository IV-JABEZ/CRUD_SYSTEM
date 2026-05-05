<?php
session_start();
include("db.php");

// Total number of items
$totalItemsQuery = mysqli_query($conn, "SELECT COUNT(*) AS total_items FROM supplies");
$totalItems = mysqli_fetch_assoc($totalItemsQuery)['total_items'] ?? 0;

// Total stock quantity
$totalStockQuery = mysqli_query($conn, "SELECT SUM(quantity) AS total_stock FROM supplies");
$totalStock = mysqli_fetch_assoc($totalStockQuery)['total_stock'] ?? 0;

// Low stock items (5 or below)
$lowStockQuery = mysqli_query($conn, "SELECT COUNT(*) AS low_stock FROM supplies WHERE quantity <= 5");
$lowStock = mysqli_fetch_assoc($lowStockQuery)['low_stock'] ?? 0;

// Recent supplies
$recentQuery = mysqli_query($conn, "SELECT * FROM supplies ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
    <title>School Supply Inventory Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 15px 30px;
        }

        .header h2 {
            margin: 0;
        }

        .container {
            width: 90%;
            margin: 25px auto;
        }

        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .card {
            flex: 1;
            min-width: 220px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .card h3 {
            margin: 0 0 10px;
            color: #555;
            font-size: 16px;
        }

        .card p {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
        }

        .table-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .table-box h3 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background: #34495e;
            color: white;
        }

        .low {
            color: red;
            font-weight: bold;
        }

        .nav {
            margin-top: 15px;
        }

        .nav a {
            display: inline-block;
            margin-right: 10px;
            padding: 10px 14px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .nav a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>School Supply Inventory Dashboard</h2>
</div>

<div class="container">

    <div class="cards">
        <div class="card">
            <h3>Total Supplies</h3>
            <p><?php echo $totalItems; ?></p>
        </div>

        <div class="card">
            <h3>Total Stock</h3>
            <p><?php echo $totalStock; ?></p>
        </div>

        <div class="card">
            <h3>Low Stock Items</h3>
            <p><?php echo $lowStock; ?></p>
        </div>
    </div>

    <div class="table-box">
        <h3>Recently Added Supplies</h3>

        <table>
            <tr>
                <th>ID</th>
                <th>Supply Name</th>
                <th>Category</th>
                <th>Quantity</th>
            </tr>

            <?php
            if ($recentQuery && mysqli_num_rows($recentQuery) > 0) {
                while ($row = mysqli_fetch_assoc($recentQuery)) {
                    echo "<tr>
                            <td>".$row['id']."</td>
                            <td>".$row['supply_name']."</td>
                            <td>".$row['category']."</td>
                            <td ".($row['quantity'] <= 5 ? "class='low'" : "").">".$row['quantity']."</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No supplies found</td></tr>";
            }
            ?>
        </table>

        <div class="nav">
            <a href="index.php">Manage Supplies</a>
            <a href="create.php">Add Supply</a>
        </div>
    </div>

</div>

</body>
</html>