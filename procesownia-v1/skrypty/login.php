<?php
session_start();

$redirect_to = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'glowna.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "procesowniadb";

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
            header("Location: " . $redirect_to);
        } else {
            echo "Wprowadzono nieprawidłowe hasło<a href='../login.html'> powrót do logowania</a>";
        }
    } else {
        echo "Nie znaleziono użytkownika<a href='../login.html'> powrót do logowania</a>";
    }
}

$conn->close();
}
?>
