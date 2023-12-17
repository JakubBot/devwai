<?php
require_once 'business.php';


function images(&$model)
{
    $images = get_thumbnails();
    $model['images'] = $images;
    $model['page'] = 0;
    $model['hasNextImages'] = checkHasNextImages();
    $model['hasPrevImages'] = checkHasPrevImages();

    $model['selected_images'] = isset($_SESSION['selected_images']) ? $_SESSION['selected_images'] : [];

    return 'images_view';
}


function save(&$model)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $uploadOk = isUploadOk($targetFile, $imageFileType);



        if ($uploadOk == 1) {
            handleUpload($targetFile);
        }

    }

    return 'save_view';

}


function register(&$model)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        registerUser();
    }

    return 'register_view';
}
function login(&$model)
{

    logInUser();

    return 'login_view';
}
function authenticate(&$model)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        authenticateUser();

    } else {
        echo '<script>window.location.href = "/login";</script>';
    }

    return 'authenticate_view';
}


function logout(&$model)
{
    logOutUser();
    echo '<script>window.location.href = "/";</script>';

}
function save_selection(&$model)
{
    return 'save_selection_view';
}
function saved_images(&$model)
{
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_selected'])) {
        handleRemoveImage();
        $model['selectedImages'] = fetchImages();
    } else {
        $model['selectedImages'] = fetchImages();
    }
    return 'saved_images_view';
}
