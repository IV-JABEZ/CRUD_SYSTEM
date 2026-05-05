<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_system";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$name = $quantity = $category = $date_added = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $date_added = date("Y-m-d");

    // Prepared statement
    $stmt = $conn->prepare("INSERT INTO supplies (name, quantity, category, date_added) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $name, $quantity, $category, $date_added);

    if ($stmt->execute()) {
        echo "<script>alert('Item added successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Supply Item</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
        }
        .container {
            width: 400px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add School Supply</h2>

    <form method="POST" action="">
        <label>Item Name:</label>
        <input type="text" name="name" required>

        <label>Quantity:</label>
        <input type="number" name="quantity" required>

        <label>Category:</label>
        <select name="category" required>
            <option value="">Select Category</option>
            <option value="Office Supplies">Office Supplies</option>
            <option value="Cleaning Materials">Cleaning Materials</option>
            <option value="Classroom Equipment">Classroom Equipment</option>
        </select>

        <button type="submit">Add Item</button>
    </form>
</div>

</body>
</html>