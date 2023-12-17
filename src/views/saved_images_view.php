<?php
// session_start();

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
    <link href="styles/reset.css" rel="stylesheet" type="text/css" />
    <link href="styles/index.css" rel="stylesheet" type="text/css" />
    <title>Zapamiętane Zdjęcia</title>
</head>

<body>
    <header class="header">
        <div></div>
        <nav class="nav">
            <ul class="navigating">
                <li class="navigation__item">
                    <a href="index.php"> Strona główna </a>
                </li>
              
                <li class="navigation__item">
                    <a href="/images">Zobacz galerie zdjec</a>
                </li>
                <li class="navigation__item">
                    <a href="/save">Dodaj zdjecie</a>
                </li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="navigation__item"><a href="/saved_images">Zobacz zapamietane zdjecia</a></li>';
                    echo '<li class="navigation__item"><a href="/logout">Wyloguj</a></li>';
                } else {
                    echo '<li class="navigation__item"><a href="/register">Rejestracja</a></li>';
                    echo '<li class="navigation__item"><a href="/login">Logowanie</a></li>';
                }
                ?>

            </ul>
        </nav>
    </header>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
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