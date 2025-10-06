<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    echo "not_allowed";
    exit();
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $user_id = intval($_SESSION['user_id']);

    // Ensure seller can only delete their own item
    $query = "DELETE FROM food_items WHERE id = $id AND user_id = $user_id";

    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_close($conn);
}
?>
