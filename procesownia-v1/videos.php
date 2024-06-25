<?php
session_start();
?>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "procesowniadb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, title, url, created_at FROM videos ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesownia</title>
    <link rel="stylesheet" href="css\style.css">
    <link rel="icon" type="image/x-icon" href="img/PROCESOWNIA.png" sizes="32x32"> 
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <h1>Pro<span>cesownia</span></h1>
                <div class="div12"> <img src="img\proc.png" width="30%" height="30%"></div>
                <p>Witamy na forum</p></br>
            </div>
            <audio autoplay loop id="myaudio">
                <source src="resources/music.mp3">
            </audio>
            <script>
                var audio = document.getElementById("myaudio"); audio.volume = 0.1;
            </script>
            <div class="user-info">
                <?php if (isset($_SESSION["login"])): ?>
                    <p><?php echo htmlspecialchars($_SESSION["login"]); ?> | <a href="glowna.php">Strona Główna</a> | <a href="skrypty\logout.php">Wyloguj</a> </p>
                <?php else: ?>
                    <p><a href="glowna.php">Strona Główna</a> | <a href="login.html">Zaloguj</a> | <a href="rejestracja.html">Zarejestruj</a></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="content">
            <div class="main-profile">
                <div class="profile-header">
                    <img src="img\baner.png" alt="Profile Picture" class="profile-pic">
                    <div class="profile-links">
                    </div>
                </div>
        <div class="profile-posts">
            <h1>Filmy pomocnicze</h1>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Pobieranie ID filmu z linku do YouTube
                    parse_str(parse_url($row["url"], PHP_URL_QUERY), $youtube_vars);
                    $youtube_id = $youtube_vars['v'];
                    echo "<div class='video'>";
                    echo "<h4>" . $row["title"] . "</h4>";
                    echo "<iframe width='700' height='300' src='https://www.youtube.com/embed/" . $youtube_id . "' frameborder='0' allowfullscreen></iframe>";
                    echo "<p class=post-header>Dodano: " . $row["created_at"] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Brak filmów do wyświetlenia</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <div class="sidebar">
                <div class="ad">
                    <h2>FAQ</h2>
                    <p class="post-header">Poniżej znajdziecie odpowiedzi na najczęściej zadawane pytania</p>
                </div>
                <div class="ad">
                    <p class="post-header">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consequat velit in sollicitudin venenatis. Vestibulum blandit suscipit erat, tempor luctus orci bibendum non
                    </p>
                </div>
                <div class="ad">
                    <img src="img\ad1.png" alt="Ad 1">
                </div>
                <div class="ad">
                    <img src="img\ad2.png" alt="Ad 2">
                </div>
                <div class="ad">
                    <img src="img\ad3.png" alt="Ad 3">
                </div>
                <div class="ad">
                    <img src="img\ad4.png" alt="Ad 4">
                </div>
                
                </div>
</body>
</html>
