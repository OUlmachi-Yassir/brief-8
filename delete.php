
​<?php
include "connection.php";
require "equipe.php";
$equipeHandler = new Equipe();

if (isset($_GET['id_equipe'])) {
    $equipeIdToDelete = $_GET['id_equipe'];

    $deletionResult = $equipeHandler->deleteEquipe($equipeIdToDelete);

    if ($deletionResult) {
        header('Location: dashboards.php');
    } else {
        echo "Error deleting equipe.";
    }
} else {
    echo "Equipe ID not provided.";
}
?>
