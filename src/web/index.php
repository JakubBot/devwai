<?php
session_start();

// Sprawdź, czy sesja istnieje
// if (session_status() === PHP_SESSION_ACTIVE) {
//   echo "Sesja istnieje.<br>";

//   // Wyświetl ID sesji
//   echo "ID sesji: " . session_id() . "<br>";

//   // Wyświetl zawartość sesji
//   echo "Zawartość sesji:<br>";
//   print_r($_SESSION);
// } else {
//   echo "Sesja nie istnieje.";
// }

// if (isset($_SESSION['user_id'])) {
//   echo "sesja " . $_SESSION['user_id'];
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link href="styles/reset.css" rel="stylesheet" type="text/css" />
  <link href="styles/index.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div class="container">
    <div class="background__wrapper">
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
      <main id="wrapper">
        <div class="wrapper__box">
          <h2 class="wrapper__title">
            <span class="orange"> Czy </span> wiesz że?
          </h2>
          <span class="wrapper__description">Archeologia to nauka badająca ślady działalności ludzkiej z
            przeszłości?
            <span class="orange">Dzięki wykopaliskom archeologicznym odkrywamy tajemnice dawnych
              cywilizacji i poznajemy historię naszego świata</span>. Czy wiesz, że najstarsze znane wykopaliska
            archeologiczne
            datowane są na kilka tysięcy lat przed naszą erą i pomagają nam
            zrozumieć, jakie osiągnięcia kulturowe i technologiczne osiągnęły
            starożytne społeczności?</span>
        </div>
      </main>
      <div id="scroll_down" class="scroll_down">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="scrollDownIcon">
          <line x1="12" y1="5" x2="12" y2="19"></line>
          <polyline points="19 12 12 19 5 12"></polyline>
        </svg>
      </div>
    </div>
    <div class="skew__background">
      <footer class="footer">
        <h4 class="footer__title">
          <span class="orange animate-text">Kon</span>takt
        </h4>
        <form class="form" id="form" action="odbierz.php" method="post">
          <div class="form__item">
            <label class="form__item__header" for="imie"> Imię </label>
            <input class="form__item__input" type="text" name="imie" id="imie" />
          </div>
          <div class="form__item">
            <label class="form__item__header" for="adress"> Adres </label>
            <input class="form__item__input" type="text" name="adress" id="adress" />
          </div>
          <div class="form__item">
            <label class="form__item__header" for="adress_email">
              Email
            </label>
            <input class="form__item__input" type="text" name="adress_email" id="adress_email" />
          </div>
          <div class="form__item">
            <label class="form__item__header" for="nowe_odkrycie">
              Odkrycie
            </label>
            <input class="form__item__input" type="text" name="nowe_odkrycie" id="nowe_odkrycie" />
          </div>
          <div class="form__item">
            <label class="form__item__header">
              Udostępnij dane kontaktowe
            </label>
            <div>
              <input type="radio" name="dane" id="udo_tak" />
              <label for="udo_tak">Tak</label>
              <input type="radio" name="dane" id="udo_nie" />
              <label for="udo_nie">Nie</label>
            </div>
          </div>
          <div class="form__item">
            <label class="form__item__header"> Dane do udostępnienia </label>

            <div>
              <input type="checkbox" id="imie" name="imie" />
              <label for="imie">Imię</label>
              <input type="checkbox" id="adres" name="adres" />
              <label for="adres">Adres</label>
              <input type="checkbox" id="email" name="email" />
              <label for="email">Email</label>
            </div>
            <div>
              <label class="form__item__header"> Wybierz kraj </label>
              <select name="kraje" id="kraje">
                <option value="polska">Polska</option>
                <option value="czechy">Czechy</option>
                <option value="niemcy">Niemcy</option>
                <option value="ukraina">Ukraina</option>
              </select>
            </div>

            <div style="display: grid; gap: 10px">
              <label class="form__item__header"> Twoja wiadomość </label>
              <textarea name="wiadomosc" id="wiadomosc" cols="30" rows="10"></textarea>
            </div>
          </div>
          <div class="nojs">
            Włącz obsługę JavaScript, aby móc korzystać z formularza
          </div>
          <div class="form__button__container">
            <div>
              <button class="form__button button--send" type="submit">
                Wyslij
              </button>
              <button class="form__button button--reset" type="reset">
                Reset
              </button>
            </div>
            <div class="">
              <button id="saveForm" class="form__button button--save" type="button">
                Zapisz formularz
              </button>
              <button id="useSavedFormData" class="form__button button--use" type="button">
                Użyj zapisanych danych
              </button>
            </div>
          </div>
        </form>
      </footer>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
  <script src="./index.js"></script>
</body>

</html>