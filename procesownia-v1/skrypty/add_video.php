<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "procesowniadb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $url = $conn->real_escape_string($_POST["url"]);
    $category_id = $conn->real_escape_string($_POST["category_id"]);

    $sql = "INSERT INTO videos (title, url) VALUES ('$title', '$url')";

    if ($conn->query($sql) === TRUE) {
        echo "New video added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj Film - Lifeinvader</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Dodaj Nowy Film</h2>
        <form action="add_video.php" method="post">
            <label for="title">Tytuł</label>
            <input type="text" id="title" name="title" required>
            
            <label for="url">Link do YouTube</label>
            <input type="url" id="url" name="url" required>

            <label for="category">Kategoria</label>
            <select id="category" name="category_id" required>
                <?php
                if ($categories_result->num_rows > 0) {
                    while($category = $categories_result->fetch_assoc()) {
                        echo "<option value='" . $category["id"] . "'>" . $category["name"] . "</option>";
                    }
                } else {
                    echo "<option value=''>Brak kategorii</option>";
                }
                ?>
            </select>
            
            <input type="submit" value="Dodaj Film">
        </form>
    </div>
</body>
</html>
