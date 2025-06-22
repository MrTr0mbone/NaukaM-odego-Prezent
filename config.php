<?php
    // Dane do połączenia z bazą danych MySQL
    $host = 'localhost';      // Adres serwera bazy danych (localhost = lokalny serwer)
    $dbname = 'abrisco';      // Nazwa bazy danych
    $user = 'root';           // Nazwa użytkownika bazy (domyślnie 'root' w XAMPP)
    $pass = '';               // Hasło użytkownika (domyślnie puste w XAMPP)

    // Nawiązanie połączenia z bazą danych za pomocą MySQLi
    $conn = new mysqli($host, $user, $pass, $dbname);

    // Sprawdzenie, czy połączenie się powiodło
    if ($conn->connect_error) {
        // Jeśli wystąpił błąd, przerwij działanie i wyświetl komunikat
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    // Rozpoczęcie sesji – musi być wywołane, jeśli korzystasz z $_SESSION
    session_start();
?>