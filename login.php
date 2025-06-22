<?php
// Dołączamy plik konfiguracyjny z połączeniem do bazy danych
require 'config.php';

// Sprawdzamy, czy formularz został przesłany metodą POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobieramy i oczyszczamy nazwę użytkownika z formularza
    $username = trim($_POST['username']);
    // Pobieramy hasło podane przez użytkownika
    $password = $_POST['password'];

    // Przygotowujemy zapytanie, które pobierze zahashowane hasło użytkownika z bazy na podstawie nazwy użytkownika
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);  // Podstawiamy nazwę użytkownika do zapytania
    $stmt->execute();
    // Powiązujemy wynik zapytania (hash hasła) do zmiennej $hash
    $stmt->bind_result($hash);

    // Jeśli udało się pobrać wynik i hasło podane w formularzu po zweryfikowaniu zgadza się z hashem z bazy
    if ($stmt->fetch() && password_verify($password, $hash)) {
        // Uruchamiamy sesję i zapisujemy nazwę użytkownika w sesji
        $_SESSION['user'] = $username;
        // Ustawiamy ciasteczko 'user' na nazwę użytkownika ważne przez 1 godzinę (3600 sekund)
        setcookie('user', $username, time() + 3600, "/");
        // Po poprawnym logowaniu przekierowujemy do strony głównej
        header("Location: index.php");
        exit();
    } else {
        // W przeciwnym razie ustawiamy komunikat o błędnych danych logowania
        $error = "Nieprawidłowe dane logowania.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="FavIcon.png" type="image/x-icon">
</head>
<body class="bgck">
    <h2 class="hab">Logowanie</h2>
    <!-- Jeśli jest ustawiony komunikat o błędzie, wyświetlamy go na czerwono na środku -->
    <?php if (isset($error)) echo "<p style='text-align:center;color:red;'>$error</p>"; ?>
    
    <!-- Formularz logowania -->
    <form method="post" style="text-align:center;">
        <input type="text" name="username" placeholder="Login" required><br><br>
        <input type="password" name="password" placeholder="Hasło" required><br><br>
        <button type="submit">Zaloguj się</button>
    </form>
    
    <!-- Link do strony rejestracji -->
    <p style="text-align:center;"><a href="register.php">Nie masz konta? Zarejestruj się</a></p>
</body>
</html>
