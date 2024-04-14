<?php

// Include the database connection
include '../connections.php';

function uploadImage() {
    $imageDir = "uploads/";
    $imageName = $_FILES["image"]["name"];
    $imagePath = $imageDir . $imageName;
    $tmpFilePath = $_FILES["image"]["tmp_name"];

    // Check if the uploads directory exists, create it if not
    if (!is_dir($imageDir)) {
        mkdir($imageDir, 0777, true);
    }

    if (move_uploaded_file($tmpFilePath, $imagePath)) {
        return $imagePath;
    } else {
        return false;
    }
}

?>
