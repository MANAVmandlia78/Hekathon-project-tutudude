<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "not_logged_in";
    exit();
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $user_id = intval($_SESSION['user_id']);

    // Only remove if the item belongs to this user
    $query = "UPDATE food_items SET cart = 0, cart_user_id = NULL WHERE id = $id AND cart_user_id = $user_id";

    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }

    mysqli_close($conn);
}
?>
