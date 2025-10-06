<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Only logged-in users can access
    exit();
}

include 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $vendor = mysqli_real_escape_string($conn, $_POST['vendor']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
    $stars = mysqli_real_escape_string($conn, $_POST['stars']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $category = mysqli_real_escape_string($conn, $_POST['category']); // New
    $user_id = $_SESSION['user_id'];  // Current seller
    $query = "INSERT INTO food_items (name, description, price, vendor, image_url, stars, rating, category , user_id, created_at) 
              VALUES ('$name', '$description', '$price', '$vendor', '$image_url', '$stars', '$rating', '$category', '$user_id', NOW())";

    if (mysqli_query($conn, $query)) {
        $message = "Item added successfully!";
    } else {
        $message = "Error adding item: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Food Item</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { max-width: 400px; margin: auto; display: flex; flex-direction: column; gap: 15px; }
        input, textarea, select { padding: 8px; font-size: 16px; }
        button { padding: 10px; background: #333; color: white; border: none; cursor: pointer; }
        .message { text-align: center; margin-bottom: 20px; color: green; }
    </style>
</head>
<body>
    <h2>Add New Food Item</h2>
    <?php if ($message) echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Item Name" required>
        <textarea name="description" placeholder="Description (e.g., 2 piece)" required></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price (₹)" required>
        <input type="text" name="vendor" placeholder="Vendor (default Street King)" value="Street King">
        <input type="text" name="image_url" placeholder="Image URL (relative path)">
        
        <!-- Category Dropdown -->
        <label for="category">Select Category</label>
        <select name="category" required>
            <option value="floure">Floure</option>
            <option value="food" selected>Food</option>
            <option value="oil">Oil</option>
            <option value="fruits">Fruits</option>
            <option value="vegitables">Vegitables</option>
            <option value="spicies">Spicies</option>
            <option value="sauses">Sauses</option>
            <option value="bakery items">Bakery Items</option>
            <option value="namkeen">Namkeen</option>
        </select>

        <select name="stars">
            <option value="★★★★★">★★★★★</option>
            <option value="★★★★☆" selected>★★★★☆</option>
            <option value="★★★☆☆">★★★☆☆</option>
            <option value="★★☆☆☆">★★☆☆☆</option>
            <option value="★☆☆☆☆">★☆☆☆☆</option>
        </select>

        <input type="number" step="0.1" name="rating" placeholder="Rating (e.g., 4.3)">
        <button type="submit">Add Item</button>
    </form>
</body>
</html>
