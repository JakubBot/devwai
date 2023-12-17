<?php
$itemsPerPage = 3;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; // Numer bieżącej strony

// Pobierz wszystkie obrazy z bazy danych
$db = get_db();
$offset = ($page - 1) * $itemsPerPage; // Oblicz offset dla zapytania do bazy danych
$images = $db->images->find(["type" => 'thumbnail'], ['limit' => $itemsPerPage, 'skip' => $offset])->toArray(); // Pobierz obrazy dla bieżącej strony

foreach ($images as $image) {
  $watermarkedPath = str_replace(["thumbnails", "thumbnail_"], ["watermark", "watermarked_"], $image['path']);

  echo '<div class="gallery__container">';
  echo '<a href="' . $watermarkedPath . '" target="_blank">';
  echo '<img title="" src="' . $image['path'] . '" alt="zdjecie" class="gallery__image originalImage" />';
  echo '</a>';
  echo '<br />';
  echo '<div>';
  echo '<span class="black wrapper__description">';
  echo 'Author: ' . (isset($image['author']) ? $image['author'] : 'Brak autora');
  echo '</span>';
  echo '</div>';
  echo '<br />';
  echo '<div>';
  echo '<span class="black wrapper__description">';
  echo 'Title: ' . (isset($image['title']) ? $image['title'] : 'Brak tytułu');
  echo '</span>';
  echo '</div>';
  echo '<div class="save_image">';
  echo '<span>Zapamietaj obraz</span>';
  echo '<input type="checkbox" name="selected_images[]" value="' . $image['_id'] . '"';

  // Sprawdź, czy obraz jest zapamiętany w sesji
  if (isset($_SESSION['selected_images']) && in_array($image['_id'], $_SESSION['selected_images'])) {
    echo ' checked';
  }

  echo '>';

  echo '</div>';
  echo '</div>';
}




?>