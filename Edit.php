<?php
include("db.php");

// Check if id is provided
if (!isset($_GET['id'])) {
    die("No item selected.");
}

$id = intval($_GET['id']);

// Get current item data
$query = "SELECT * FROM school_supply WHERE id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Item not found.");
}

$item = mysqli_fetch_assoc($result);

// Update item when form is submitted
if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity = intval($_POST['quantity']);
    $borrowed_by = mysqli_real_escape_string($conn, $_POST['borrowed_by']);
    $date_borrowed = mysqli_real_escape_string($conn, $_POST['date_borrowed']);

    $update = "UPDATE school_supply SET
                name = '$name',
                category = '$category',
                quantity = $quantity,
                borrowed_by = '$borrowed_by',
                date_borrowed = '$date_borrowed'
               WHERE id = $id";

    if (mysqli_query($conn, $update)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating item: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit School Supply Item</title>
</head>
<body>

<h2>Edit Item</h2>

<form method="POST">
    <label>Name:</label><br>
    <input type="text" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>
    <br><br>

    <label>Category:</label><br>
    <input type="text" name="category" value="<?php echo htmlspecialchars($item['category']); ?>" required>
    <br><br>

    <label>Quantity:</label><br>
    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" required>
    <br><br>

    <label>Borrowed By:</label><br>
    <input type="text" name="borrowed_by" value="<?php echo htmlspecialchars($item['borrowed_by']); ?>">
    <br><br>

    <label>Date Borrowed:</label><br>
    <input type="date" name="date_borrowed" value="<?php echo $item['date_borrowed']; ?>">
    <br><br>

    <button type="submit" name="update">Update Item</button>
</form>

</body>
</html>