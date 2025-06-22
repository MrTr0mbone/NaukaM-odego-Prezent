<?php
// Dołączamy plik konfiguracyjny z połączeniem do bazy danych
require 'config.php';

// Sprawdzamy, czy formularz został przesłany metodą POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobieramy i oczyszczamy dane z formularza
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Sprawdzamy, czy oba pola zostały wypełnione
    if ($username && $password) {
        // Przygotowujemy zapytanie, aby sprawdzić, czy użytkownik o podanej nazwie już istnieje
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);  // Podstawiamy nazwę użytkownika do zapytania
        $stmt->execute();
        $stmt->store_result();

        // Jeśli istnieje już taki użytkownik, ustawiamy komunikat o błędzie
        if ($stmt->num_rows > 0) {
            $error = "Użytkownik już istnieje!";
        } else {
            // Jeśli użytkownik nie istnieje, haszujemy podane hasło
            $hash = password_hash($password, PASSWORD_DEFAULT);
            // Przygotowujemy zapytanie do wstawienia nowego użytkownika do bazy
            $insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $insert->bind_param('ss', $username, $hash);  // Podstawiamy nazwę i hasło
            $insert->execute();
            // Po pomyślnej rejestracji przekierowujemy do strony logowania
            header("Location: login.php");
            exit();
        }
    } else {
        // Jeśli któreś pole jest puste, ustawiamy komunikat o błędzie
        $error = "Wypełnij wszystkie pola!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="FavIcon.png" type="image/x-icon">
</head>
<body class="bgck">
    <h2 class="hab">Rejestracja</h2>
    <!-- Jeśli jest ustawiony komunikat o błędzie, wyświetlamy go na środku na czerwono -->
    <?php if (isset($error)) echo "<p style='text-align:center;color:red;'>$error</p>"; ?>
    
    <!-- Formularz rejestracji -->
    <form method="post" style="text-align:center;">
        <input type="text" name="username" placeholder="Login" required><br><br>
        <input type="password" name="password" placeholder="Hasło" required><br><br>
        <button type="submit">Zarejestruj się</button>
    </form>
    
    <!-- Link do strony logowania -->
    <p style="text-align:center;"><a href="login.php">Masz konto? Zaloguj się</a></p>
</body>
</html>
