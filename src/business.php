<?php


use MongoDB\BSON\ObjectID;


function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}

function save_image($id, $image)
{
    $db = get_db();


    if ($id == null) {
        $db->images->insertOne($image);
    } else {
        $db->images->replaceOne(['_id' => new ObjectID($id)], $image);
    }

    return true;
}


function get_images()
{
    $db = get_db();
    $_imgs = $db->images->find()->toArray();
    return $_imgs;

}

function get_thumbnails()
{
    $db = get_db();
    $_imgs = $db->images->find(['type' => 'thumbnail'])->toArray();
    return $_imgs;
}

function applyWatermark($originalImagePath, $watermarkText)
{
    $image = imagecreatefromjpeg($originalImagePath);

    $textColor = imagecolorallocate($image, 255, 255, 255); // biały kolor
    $fontSize = 30;

    $x = (imagesx($image) - strlen($watermarkText) * imagefontwidth($fontSize)) / 2;
    $y = (imagesy($image) - imagefontheight($fontSize)) / 2;

    imagestring($image, $fontSize, $x, $y, $watermarkText, $textColor);
    $watermarkedImagePath = 'uploads/watermark/watermarked_' . basename($originalImagePath);

    imagejpeg($image, $watermarkedImagePath);

    imagedestroy($image);

    return $watermarkedImagePath;
}

function generateThumbnail($imagePath)
{
    $originalImage = imagecreatefromjpeg($imagePath);
    $width = imagesx($originalImage);
    $height = imagesy($originalImage);
    $thumbnail = imagecreatetruecolor(200, 125);

    imagecopyresampled($thumbnail, $originalImage, 0, 0, 0, 0, 200, 125, $width, $height);

    $thumbnailPath = "uploads/thumbnails/thumbnail_" . basename($imagePath);

    imagejpeg($thumbnail, $thumbnailPath);

    imagedestroy($originalImage);
    imagedestroy($thumbnail);

    return $thumbnailPath;
}

function addImage($db, $name, $targetFile, $type)
{
    $title = isset($_POST["title"]) ? htmlspecialchars($_POST["title"]) : "";
    $author = isset($_POST["author"]) ? htmlspecialchars($_POST["author"]) : "";

    try {
        $db->images->insertOne([
            'name' => $name,
            'path' => $targetFile,
            'type' => $type,
            'title' => $title,
            'author' => $author,
        ]);

        return true;
    } catch (Exception $e) {
        error_log("Błąd przy dodawaniu obrazu do bazy danych: " . $e->getMessage());
        return false;

    }

}

function checkHasNextImages()
{
    $db = get_db();
    $itemsPerPage = 3;
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // Numer bieżącej strony
    $offset = ($page - 1) * $itemsPerPage; // Oblicz offset dla zapytania do bazy danych
    $nextPageImages = $db->images->find(["type" => 'thumbnail'], ['limit' => $itemsPerPage, 'skip' => $offset + $itemsPerPage])->toArray();
    if (count($nextPageImages) > 0) {
        return true;
    }
    return false;
}

function checkHasPrevImages()
{
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // Numer bieżącej strony
    if ($page > 1) {
        return true;
    }
    return false;
}

function isUploadOk($targetFile, $imageFileType)
{
    $uploadOk = 1;
    if (file_exists($targetFile)) {
        echo "Przepraszamy, plik już istnieje.";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 1000000) {
        echo "Przepraszamy, plik jest zbyt duży. Maksymalny rozmiar zdjecia to 1mb. ";
        $uploadOk = 0;
    }

    $allowedExtensions = array("jpg", "jpeg", "png");
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Przepraszamy, dozwolone są tylko pliki JPG, JPEG, PNG.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Przepraszamy, twój plik nie został przesłany.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        } else {
            echo "Przepraszamy, wystąpił błąd podczas przesyłania pliku.";
        }
    }
    return $uploadOk;
}

function handleUpload($targetFile)
{
    $db = get_db();


    try {
        addImage($db, htmlspecialchars(basename($_FILES["fileToUpload"]["name"])), $targetFile, 'original');

        $watermarkImagePath = applyWatermark($targetFile, $_POST["watermarkText"]);

        addImage($db, htmlspecialchars(basename($_FILES["fileToUpload"]["name"])), $watermarkImagePath, 'watermarked');

        // Generate and save thumbnail
        $thumbnailPath = generateThumbnail($targetFile);

        addImage($db, htmlspecialchars(basename($_FILES["fileToUpload"]["name"])), $thumbnailPath, 'thumbnail');

    } catch (Exception $e) {
        echo "Przepraszamy, wystąpił błąd podczas dodawania informacji o pliku do bazy danych.";
    }
    echo '<script>window.location.href = "/images";</script>';
}

function registerUser()
{
    $error_message = null;
    if (empty($_POST["email"]) || empty($_POST["login"]) || empty($_POST["password"]) || empty($_POST["confirm_password"])) {
        $error_message = "Wszystkie pola są wymagane.";
    } else {
        // Sprawdź, czy hasła się zgadzają
        if ($_POST["password"] !== $_POST["confirm_password"]) {
            $error_message = "Hasła nie są zgodne.";
        } else {
            $email = $_POST["email"];
            $login = $_POST["login"];
            $password = $_POST["password"];

            // Sprawdź, czy login jest już zajęty
            $db = get_db();
            $existingUser = $db->users->findOne(['login' => $login]);

            if ($existingUser) {
                $error_message = "Podany login jest już zajęty. Wybierz inny.";
            } else {
                // Haszuj hasło
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Zapisz użytkownika do bazy danych
                $db->users->insertOne([
                    'email' => $email,
                    'login' => $login,
                    'password' => $hashedPassword,
                ]);

                // Przekieruj użytkownika po udanej rejestracji
                echo '<script>window.location.href = "/";</script>';
                exit();
            }
        }
    }

    if (isset($error_message)) {
        echo '<p style="color: red;">' . $error_message . '</p>';
    }
}

function findUser($user_id)
{
    $db = get_db();

    $user = $db->users->findOne(['login' => $user_id]);

    return $user;
}

function authenticateUser()
{
    session_start();
    $login = $_POST['login'];
    $password = $_POST['password'];
    $user = findUser($login);

    $storedHashedPassword = $user['password'];

    if ($user != null && password_verify($password, $storedHashedPassword)) {
        session_regenerate_id();
        $_SESSION['user_id'] = $user['login'];
        echo '<script>window.location.href = "/";</script>';
        exit();
    } else {
        $_SESSION['login_error'] = "Nieprawidłowy login lub hasło";
        echo '<script>window.location.href = "/login";</script>';
        exit();
    }
}
function logOutUser()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION = [];

    session_unset();
    session_destroy();

}

function logInUser()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['user_id'])) {
        header('Location: /index.php');
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        authenticateUser();
    }
}

function convertToStringIds($selectedImageIds)
{
    $selectedImageIdsStrings = [];
    foreach ($selectedImageIds as $objectId) {
        $selectedImageIdsStrings[] = (string) $objectId;
    }
    return $selectedImageIdsStrings;
}
function fetchImages()
{
    $selectedImageIds = isset($_SESSION['selected_images']) ? $_SESSION['selected_images'] : [];
    $selectedImageUrls = [];

    if (!empty($selectedImageIds)) {
        $db = get_db();

        $convertedImageIds = array_map(function ($id) {

            return new ObjectID($id);
        }, convertToStringIds($selectedImageIds));
        $selectedImagesCursor = $db->images->find(['_id' => ['$in' => $convertedImageIds]]);



        $selectedImages = iterator_to_array($selectedImagesCursor);

        foreach ($selectedImages as $image) {
            $selectedImageUrls[] = ['_id' => $image['_id'], 'path' => $image['path']];
        }

    } else {
        echo 'Brak zapisanych zdjęć w sesji.';
    }
    return $selectedImageUrls;
}

function handleRemoveImage()
{
    $selectedImages = isset($_SESSION['selected_images']) ? $_SESSION['selected_images'] : [];

    $imagesToRemove = isset($_POST['selected_images']) ? $_POST['selected_images'] : [];

    $filtredImages = array_diff($selectedImages, $imagesToRemove);
    $_SESSION['selected_images'] = $filtredImages;

}