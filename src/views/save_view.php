<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <title>Zdjecia</title>

  <link href="styles/reset.css" rel="stylesheet" type="text/css" />
  <link href="styles/index.css" rel="stylesheet" type="text/css" />
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
  <div class="save_view_container php_wrapper">
    <h2>Prześlij zdjęcie</h2>

    <form action="/save" method="post" enctype="multipart/form-data">
      <input type="file" name="fileToUpload" id="fileToUpload" required>
      <div>
        Watermark text:
        <input type="text" name="watermarkText" id="watermarkText" required>
      </div>
      <div>
        Author:
        <input type="text" name="author" id="author">
      </div>
      <div>
        Title:
        <input type="text" name="title" id="title">
      </div>


      <input type="submit" value="Prześlij" name="submit">
    </form>

  </div>

</body>

</html>