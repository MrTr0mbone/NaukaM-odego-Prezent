<?php
  // Dołączenie pliku konfiguracyjnego (np. połączenie z bazą danych, sesja itp.)
  require 'config.php';

  // Sprawdzenie, czy cookie 'user' istnieje i ma wartość 0 (czyli użytkownik niezalogowany lub nieautoryzowany)
  // Jeśli tak, przekieruj użytkownika do strony logowania
  if ($_COOKIE['user'] == 0){
    header("Location: login.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona główna</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="FavIcon.png" type="image/x-icon">
    <script>
        // Funkcja do rozwijania/zamykania menu po kliknięciu przycisku
        function toggleMenu() {
            const menu = document.getElementById('menu');
            menu.classList.toggle('open');
        }

        // Skrypt wykrywający powrót na stronę za pomocą przycisku "Wstecz" w przeglądarce
        // Jeżeli strona została załadowana z pamięci podręcznej (cache), wymusza jej odświeżenie
        window.addEventListener("pageshow", function(event) {
          if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            window.location.reload();
          }
        });
    </script>
</head>
<body class="bgck">
  <!-- Kontener z menu -->
  <div class="menu-container">
      <!-- Przycisk do rozwinięcia menu -->
      <button class="menu-button" onclick="toggleMenu()">☰ Menu</button>

      <!-- Zawartość rozwijanego menu -->
      <div class="menu" id="menu">
          <a href="#">Strona główna</a>
          <a href="#">Usługi</a>
          <a href="#">Opinie</a>
          <a href="logout.php">Wyloguj się</a> <!-- Link do wylogowania -->
      </div>
  </div>

  <!-- Nagłówek z powitaniem użytkownika -->
  <header class="hab">Witaj <?= htmlspecialchars($_SESSION['user']) ?>!</header>

  <!-- Informacja o wartości ciasteczka użytkownika -->
  <p style="text-align:center;">🔐 Zalogowany użytkownik (cookie): <?= htmlspecialchars($_COOKIE['user']) ?></p>

  <!-- Przycisk widoczny tylko po zalogowaniu i obecności ciasteczka -->
  <div style="text-align:center;margin-top:50px;">
      <button class="przejscie">Sekcja dostępna tylko z cookie</button>
  </div>

</body>
</html>
