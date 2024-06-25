<?php
session_start();

// Połączenie z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "procesowniadb";
$url = "login.html";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $conn->real_escape_string($_POST["login"]);
    $password = $conn->real_escape_string($_POST["password"]);

    $sql = "SELECT id, password FROM users WHERE login='$login'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["login"] = $login;
            header("Location: glowna.php");
        } else {
            echo "Wprowadzono nieprawidłowe hasło<a href='$url'> powrót do logowania</a>";
        }
    } else {
        echo "Nie znaleziono użytkownika.";
    }
}

$conn->close();
?>
