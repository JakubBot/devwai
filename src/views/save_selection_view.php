<?php
// session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sessionImages = isset($_SESSION['selected_images']) ? $_SESSION['selected_images'] : [];
    $selectedImages = isset($_POST['selected_images']) ? $_POST['selected_images'] : [];

    $_SESSION['selected_images'] = array_unique(array_merge($sessionImages, $selectedImages));

    header('Location: images');
    exit();
}
?>


<!DOCTYPE html>
<html>

<head>
</head>

<body>


</body>

</html>