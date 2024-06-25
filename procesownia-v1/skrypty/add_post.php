<?php
// Połączenie z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "procesowniadb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Połączenie nieudane: " . $conn->connect_error);
}

// Sprawdzenie czy formularz został przesłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author_name = $conn->real_escape_string($_POST["author_name"]);
    $content = $conn->real_escape_string($_POST["content"]);
    $image = NULL;

    // Sprawdzenie, czy obrazek został przesłany
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $conn->real_escape_string($target_file);
        } else {
            echo "Błąd przesyłania pliku.";
        }
    }

    // Wstawienie nowego posta do bazy danych
    $sql = "INSERT INTO posts (author_name, content, image) VALUES ('$author_name', '$content', '$image')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../glowna.php"); // Przekierowanie do strony głównej
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
