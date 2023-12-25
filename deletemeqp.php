<?php
include "connection.php";
include "User.php"; 

$user = new User($conn);

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $user->updateUserEquipe($userId);
} else {
    echo "User ID not provided.";
}
?>
