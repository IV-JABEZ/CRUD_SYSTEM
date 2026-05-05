<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO items (name, category, quantity)
            VALUES ('$name', '$category', '$quantity')";

    if (mysqli_query($conn, $sql)) {
        echo "Item added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
</head>
<body>

<h2>Add School Supply</h2>

<form method="POST">
    <label>Item Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Category:</label><br>
    <input type="text" name="category"><br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" required><br><br>

    <button type="submit" name="submit">Add Item</button>
</form>

</body>
</html>