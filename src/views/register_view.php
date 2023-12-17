
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rejestracja</title>
</head>

<body>
  <h2>Formularz rejestracji</h2>

  <form method="post" action="">
    <label for="email">Adres e-mail:</label>
    <input type="email" name="email" required>
    <br>

    <label for="login">Login:</label>
    <input type="text" name="login" required>
    <br>

    <label for="password">Hasło:</label>
    <input type="password" name="password" required>
    <br>

    <label for="confirm_password">Powtórz hasło:</label>
    <input type="password" name="confirm_password" required>
    <br>

    <input type="submit" value="Zarejestruj">
  </form>
</body>

</html>