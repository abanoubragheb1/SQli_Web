<?php
ob_start();
session_start();
$pageTitle = 'Confirm Buy';
include 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_confirm_buy'])) {
    if (isset($_SESSION['user'])) {
        $userid = $_SESSION['uid'];
        $itemId = isset($_POST['item_id']) && is_numeric($_POST['item_id']) ? intval($_POST['item_id']) : 0;
        $quantity = isset($_POST['quantity']) && is_numeric($_POST['quantity']) ? intval($_POST['quantity']) : 0;

        // Get the item price
        $stmt = $con->prepare("SELECT Price FROM items WHERE Item_ID = ?");
        $stmt->execute(array($itemId));
        $itemDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        $price = $itemDetails['Price'];

        // Calculate the total price
        $totalPrice = $quantity * $price;

        // Insert a record into the confirm-buy table
        $stmt = $con->prepare("INSERT INTO `confirm-buy` (Item_ID, Member_ID, Confirmation_Date) VALUES (?, ?, NOW())");
        $stmt->execute(array($itemId, $userid));

        // Update the item status to "Buy"
        $stmt = $con->prepare("UPDATE items SET Status = 'Buy' WHERE Item_ID = ?");
        $stmt->execute(array($itemId));

        // Redirect to the buy page with the item ID as a parameter
        header('Location: confirm-buy.php?item_id=' . $itemId);
        exit(); // Make sure to exit after sending the header
    } else {
        echo '<div class="container">';
        echo '<div class="alert alert-danger">You need to login to confirm the purchase</div>';
        echo '</div>';
    }
}







// Check if the user is logged in
if (isset($_SESSION['user'])) {
    $userid = $_SESSION['uid'];

    // Fetch items only for the logged-in user
    $stmt = $con->prepare("SELECT items.*, `confirm-buy`.Confirmation_Date FROM items
                          INNER JOIN `confirm-buy` ON items.Item_ID = `confirm-buy`.Item_ID
                          WHERE `confirm-buy`.Member_ID = ?");
    $stmt->execute(array($userid));
    $userItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<div class="contain">';
    if ($userItems) {
        echo '<h2>Items Added to Confirm Buy:</h2>';
        echo '<ul>';
        foreach ($userItems as $item) {
            echo '<li>' . $item['Name'] . ' - $' . $item['Price'] . ' - Confirmed on ' . $item['Confirmation_Date'] . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No items added for confirmation.</p>';
    }
    echo '</div>';
} else {
    // If the user is not logged in, display an error message
    echo '<div class="container">';
    echo '<div class="alert alert-danger">You need to login to view the confirmation page</div>';
    echo '</div>';
}

include $tpl . 'footer.php';
ob_end_flush();
?>