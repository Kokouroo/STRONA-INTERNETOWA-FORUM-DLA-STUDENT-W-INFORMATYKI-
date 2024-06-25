<?php

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

    $sql = "INSERT INTO videos (title, url) VALUES ('$title', '$url')";

    if ($conn->query($sql) === TRUE) {
        header("Location: videos.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
