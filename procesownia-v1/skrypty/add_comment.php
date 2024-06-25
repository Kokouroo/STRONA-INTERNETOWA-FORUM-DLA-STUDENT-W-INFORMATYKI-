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
    $post_id = intval($_POST["post_id"]);
    $author_name = $conn->real_escape_string($_POST["author_name"]);
    $content = $conn->real_escape_string($_POST["content"]);

    // Wstawienie nowego komentarza do bazy danych
    $sql = "INSERT INTO comments (post_id, author_name, content) VALUES ('$post_id', '$author_name', '$content')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../glowna.php"); // Przekierowanie do strony głównej
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
