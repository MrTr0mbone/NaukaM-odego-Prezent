<?php
    // Rozpoczęcie sesji (musi być wywołane, aby móc ją usunąć)
    session_start();

    // Usunięcie wszystkich zmiennych sesji
    session_unset();

    // Zniszczenie całej sesji (usunie także identyfikator sesji z serwera)
    session_destroy();

    // Usunięcie ciasteczka "user" przez ustawienie go z przeszłą datą ważności
    setcookie("user", "", time() - 3600, "/"); // "/" oznacza dostępność w całej domenie

    // Przekierowanie użytkownika z powrotem do strony logowania
    header("Location: login.php");
    exit();
?>
