<?php
require_once 'business.php';
require_once 'controller_utils.php';


function products(&$model)
{
    $products = get_products();
    $model['products'] = $products;

    return 'products_view';
}

function product(&$model)
{
    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        if ($product = get_product($id)) {
            $model['product'] = $product;
            return 'product_view';
        }
    }

    http_response_code(404);
    exit;
}

function edit(&$model)
{
    $product = [
        'name' => null,
        'price' => null,
        'description' => null,
        '_id' => null
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (
            !empty($_POST['name']) &&
            !empty($_POST['price']) /* && ...*/
        ) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;

            $product = [
                'name' => $_POST['name'],
                'price' => (int) $_POST['price'],
                'description' => $_POST['description']
            ];

            if (save_product($id, $product)) {
                return 'redirect:products';
            }
        }
    } elseif (!empty($_GET['id'])) {
        $product = get_product($_GET['id']);
    }

    $model['product'] = $product;

    return 'edit_view';
}

function delete(&$model)
{
    if (!empty($_REQUEST['id'])) {
        $id = $_REQUEST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            delete_product($id);
            return 'redirect:products';

        } else {
            if ($product = get_product($id)) {
                $model['product'] = $product;
                return 'delete_view';
            }
        }
    }

    http_response_code(404);
    exit;
}

function cart(&$model)
{
    $model['cart'] = get_cart();
    return 'partial/cart_view';
}

function add_to_cart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $product = get_product($id);

        $cart = &get_cart();
        $amount = isset($cart[$id]) ? $cart[$id]['amount'] + 1 : 1;

        $cart[$id] = ['name' => $product['name'], 'amount' => $amount];

        return 'redirect:' . $_SERVER['HTTP_REFERER'];
    }
}

function clear_cart()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['cart'] = [];
        return 'redirect:' . $_SERVER['HTTP_REFERER'];
    }
}


function images(&$model)
{
    $images = get_thumbnails();
    $model['images'] = $images;
    $model['page'] = 0;
    $model['hasNextImages'] = checkHasNextImages();
    $model['hasPrevImages'] = checkHasPrevImages();
    // $model['selected_images'] = $images;
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
