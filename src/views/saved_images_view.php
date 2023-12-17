<?php
session_start();

// Pobierz zapamiętane zdjęcia z sesji
// $selectedImages = isset($_SESSION['selected_images']) ? $_SESSION['selected_images'] : [];

// // Sprawdź, czy formularz usuwania został przesłany
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_selected'])) {
//     // Pobierz zaznaczone zdjęcia do usunięcia
//     $imagesToRemove = isset($_POST['selected_images']) ? $_POST['selected_images'] : [];

//     // Usuń zaznaczone zdjęcia ze zbioru zapamiętanych w sesji
//     $selectedImages = array_diff($selectedImages, $imagesToRemove);

//     // Zaktualizuj sesję
//     $_SESSION['selected_images'] = $selectedImages;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zapamiętane Zdjęcia</title>
</head>

<body>

    <h1>Zapamiętane Zdjęcia</h1>

    <form action="" method="post">
        <?php foreach ($selectedImages as $image): ?>
            <div>
                <img src="<?php echo $image['path']; ?>" alt="Zdjęcie">
                <input type="checkbox" name="selected_images[]" value="<?php echo $image['_id']; ?>">
            </div>
        <?php endforeach; ?>

        <button type="submit" name="remove_selected">Usuń zaznaczone z zapamiętanych</button>
    </form>

</body>

</html>