<?php
session_start();


?>
<!DOCTYPE html>
<html>

<head>
  <title>Zdjecia</title>

  <link href="styles/reset.css" rel="stylesheet" type="text/css" />
  <link href="styles/index.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" />
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

  <div class="php_wrapper">

    <div class="gallery__wrapper">
      <span class="gallery__title">Niesamowite zdjęcia</span>
      <div class="slider__wrapper">

        <?php if (count($images)): ?>
          <form action="/save_selection" method="post">

            <div class="gallery slider">
              <?php include 'load_more_images.php'; ?>
            </div>
            <?php if ($hasPrevImages == true): ?>
              <a href="?page=<?php echo max(1, $page - 1); ?>">
                <button class="button previous">
                  <i class="fac fa-prev"></i>
                </button>
              </a>
            <?php endif ?>

            <?php if ($hasNextImages == true): ?>
              <a class="next_btn" href="?page=<?php echo $page + 1; ?>">
                <button class="button "><i class="fac fa-next"></i></button>
              </a>
            <?php endif ?>

            <input type="submit" value="Zapamiętaj wybrane">
          </form>
        </div>
      <?php else: ?>
        <tr>
          <td colspan="3">Brak zdjec</td>
        </tr>
      <?php endif ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://npmcdn.com/flickity@2/dist/flickity.pkgd.js"></script>
    <script src="https://unpkg.com/tilt.js@1.1.13/dest/tilt.jquery.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.2.0/js/all.js"></script>
    <script>
      <?php
      $file = '../web/wydarzenia.js';

      if (file_exists($file)) {
        $contents = readfile($file);
        echo $contents;
      }
      ?>
    </script>

    <!-- <script>
      $(document).ready(function () {
        var page = 1;

        // Funkcja do wczytywania kolejnych zdjęć
        function loadMoreImages() {
          $.ajax({
            url: 'load_more_images.php',
            type: 'GET',
            data: { page: page },
            success: function (data) {
              if (data !== '') {
                $('.gallery').append(data);
                page++;
              }
            }
          });
        }

        // Wywołaj funkcję, gdy strona jest gotowa
        loadMoreImages();

        // Dodaj obsługę przycisku "Wczytaj więcej"
        $('#loadMoreButton').click(function () {
          loadMoreImages();
        });
      });
    </script> -->

</body>

</html>