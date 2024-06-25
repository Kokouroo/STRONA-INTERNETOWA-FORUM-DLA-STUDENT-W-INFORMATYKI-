<?php
session_start();
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
                    <p><?php echo htmlspecialchars($_SESSION["login"]); ?> | <a href="videos.php">Filmy</a> | <a href="skrypty\logout.php">Wyloguj</a> </p>
                <?php else: ?>
                    <p><a href="videos.php">Filmy</a> | <a href="login.html">Zaloguj</a> | <a href="rejestracja.html">Zarejestruj</a></p>
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
            <h2>Dodaj film z YouTube</h2>
            <form action="skrypty\save_video.php" method="post">
                <input type="text" name="title" placeholder="Tytuł filmu" required>
                <input style="width: 98%;" type="url" name="url" placeholder="Link do filmu" required>
                <input style="width: 100%;" type="submit" value="Dodaj film">
            </form>
        </div>
                <!-- Formularz dodawania postów -->
                <?php if (isset($_SESSION["login"])): ?>
                <div class="profile-posts">
                    <h3>Dodaj Post</h3>
                    <form action="skrypty\add_post.php" method="post" enctype="multipart/form-data">
                    <?php if (isset($_SESSION["login"])): ?>
                            <input type="text" name="author_name" placeholder="Twoja Nazwa" value="<?php echo htmlspecialchars($_SESSION["login"]); ?>" required readonly>
                        <?php else: ?>
                            <input type="text" name="author_name" placeholder="Twoja Nazwa" value="Anonim" required>
                        <?php endif; ?>
                        <textarea name="content" placeholder="Twój post" required></textarea>
                        <input type="submit" value="Wyślij">
                    </form>
                </div>
                <?php endif; ?>


                <div class="profile-posts">
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

                    // Zapytanie SQL do pobrania postów
                    $sql = "SELECT id, author_name, content, image, timestamp FROM posts ORDER BY timestamp DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="post">';
                            echo '<div class="post-header">';
                            echo '<p><strong>' . $row["author_name"] . '</strong> dodał post</p>';
                            echo '<p>' . date("G:i d-m-Y", strtotime($row["timestamp"])) . '</p>';
                            echo '</div>';
                            echo '<p>' . $row["content"] . '</p>';
                            echo '<div class="post-actions">';
                            echo '</div>';

                            // Sekcja komentarzy
                            $post_id = $row["id"];
                            $comment_sql = "SELECT author_name, content, timestamp FROM comments WHERE post_id = $post_id ORDER BY timestamp ASC";
                            $comment_result = $conn->query($comment_sql);

                            echo '<div class="post-comment">';
                            if ($comment_result->num_rows > 0) {
                                while($comment_row = $comment_result->fetch_assoc()) {
                                    echo '<div class="post-comment">';
                                    echo '<div class="post-header">';
                                    echo '<p><strong>' . $comment_row["author_name"] . ' </strong>Dodał Komentarz </p>';
                                    echo   date("G:i d-m-Y ", strtotime($comment_row["timestamp"])) ;
                                    echo '</div>' ;
                                    echo '<p>' . $comment_row["content"] . '</p>';
                                    echo '</div>';
                                }
                            }
                            echo '</div>';

                            // Formularz dodawania komentarza
                            echo '<div class="post-comment">';
                            echo '<form action="skrypty\add_comment.php" method="post">';
                            echo '<input type="hidden" name="post_id" value="' . $row["id"] . '">';
                            if (isset($_SESSION["login"])) {
                                echo '<input type="text" name="author_name" placeholder="Twoja Nazwa" value="' . htmlspecialchars($_SESSION["login"]) . '" required readonly>';
                            } else {
                                echo '<input type="text" name="author_name" placeholder="Twoja Nazwa" value="Anonim" required >';
                            }
                            echo '<textarea name="content" placeholder="Napisz komentarz" required></textarea>';
                            echo '<input type="submit" value="Dodaj Komentarz">';
                            echo '</form>';
                            
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "No posts found.";
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
            </div>
        </div>
    </div>
</body>
</html>
