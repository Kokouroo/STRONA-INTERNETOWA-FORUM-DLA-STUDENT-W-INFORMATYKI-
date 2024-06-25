<?php
$servername = "localhost";
$username = "root"; // Użytkownik MySQL (np. root)
$password = ""; // Hasło MySQL, puste jeśli nie ustawione
$dbname = "procesowniadb"; // Nazwa bazy danych

// Utworzenie połączenia
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}

$login = $password = $email = "";
$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashowanie hasła
    $email = $_POST['email'];

    // Sprawdzenie czy użytkownik o podanym loginie już istnieje
    $check_query = "SELECT * FROM users WHERE login = ?";
    if ($stmt_check = $conn->prepare($check_query)) {
        $stmt_check->bind_param("s", $login);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // Użytkownik o takim loginie już istnieje
            $login_error = "Użytkownik o loginie '$login' już istnieje.";
        } else {
            // Dodawanie nowego użytkownika do bazy danych
            $insert_query = "INSERT INTO users (login, password, email) VALUES (?, ?, ?)";
            if ($stmt_insert = $conn->prepare($insert_query)) {
                $stmt_insert->bind_param("sss", $login, $password, $email);
                if ($stmt_insert->execute()) {
                    // Nowy użytkownik został zarejestrowany pomyślnie
                    echo "Nowy użytkownik został zarejestrowany pomyślnie.";
                    // Przekierowanie użytkownika na stronę z formularzem
                    header("refresh:2; url=rejestracja.html");
                    exit(); // Zatrzymanie dalszego wykonywania skryptu
                } else {
                    echo "Błąd podczas dodawania użytkownika: " . $stmt_insert->error;
                }
                $stmt_insert->close();
            } else {
                echo "Błąd przygotowania zapytania: " . $conn->error;
            }
        }
    } else {
        echo "Błąd przygotowania zapytania: " . $conn->error;
    }

    $stmt_check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz rejestracyjny</title>
    <link rel="icon" type="image/x-icon" href="img/PROCESOWNIA.png" sizes="32x32"> 
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div class="container">
        <div class="header">
            <div class="logo">
                <h1>Pro<span>cesownia</span></h1>
                <div class="div12"> <img src="img\proc.png" width="30%" height="30%"></div>
                <p>Witamy na forum</p></br>
            </div>
            <div class="user-info">
                <p><a href="glowna.php"> Strona Główna </a> | <a href="login.html">Zaloguj</a></p>
            </div>
        </div>
        <div class="content">
            <div class="main-profile">
                <div class="profile-header">
                    <img src="img\baner.png" alt="Profile Picture" class="profile-pic">
                    <div class="profile-links">
                    </div>
                </div>
    <h2>Formularz rejestracyjny</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="profile-posts">
    <?php if (!empty($login_error)) : ?>
        <p style="color: red;"><?php echo $login_error; ?></p>
    <?php endif; ?>
        Login: <input type="text" name="login" value="<?php echo htmlspecialchars($login); ?>" required><br><br>
        Hasło: <input style="width: 98%;" type="password" name="password" required><br><br>
        Email: <input style="width: 98%;" type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>
        <input type="submit" value="Zarejestruj">
        <p>Masz konto? <a href="login.html">Zaloguj się</a></p>
    
    </form>

    
    </div>
</body>
</html>