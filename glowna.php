<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lifeinvader</title>
    <link rel="stylesheet" href="style.css">
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
                <p>Zarejestruj się | <a href="#logout">Zaloguj</a></p>
            </div>
        </div>
        <div class="content">
            <div class="main-profile">
                <div class="profile-header">
                    <img src="img\baner.png" alt="Profile Picture" class="profile-pic">
                    <div class="profile-links">
                    </div>
                </div>
               
                
                <!-- Formularz dodawania postów -->
                <div class="profile-posts">
                    <h3>Dodaj Post</h3>
                    <form action="add_post.php" method="post" enctype="multipart/form-data">
                        <input class="dod-post" type="text" name="author_name" placeholder="Twoja Nazwa" required>
                        <textarea class="post-comments" name="content" placeholder="Twój post" required></textarea>
                        <input class="knefel" type="submit" value="Post">
                    </form>
                </div>
                
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
                            echo '<p>' . $row["author_name"] . ' dodał post</p>';
                            echo '<p>' . date("G:i d-m-Y", strtotime($row["timestamp"])) . '</p>';
                            echo '</div>';
                            if ($row["image"]) {
                                echo '<img src="' . $row["image"] . '" alt="Zdjęcie" class="post-image">';
                            }
                            echo '<p>' . $row["content"] . '</p>';
                            echo '<div class="post-actions">';
                            echo '</div>';

                            // Sekcja komentarzy
                            $post_id = $row["id"];
                            $comment_sql = "SELECT author_name, content, timestamp FROM comments WHERE post_id = $post_id ORDER BY timestamp DESC";
                            $comment_result = $conn->query($comment_sql);

                            echo '<div class="post-comments">';
                            if ($comment_result->num_rows > 0) {
                                while($comment_row = $comment_result->fetch_assoc()) {
                                    echo '<div class="comment">';
                                    echo '<p><strong>' . $comment_row["author_name"] . ':</strong> ' . $comment_row["content"] . ' <em>' . date("d M Y", strtotime($comment_row["timestamp"])) . '</em></p>';
                                    echo '</div>';
                                }
                            }
                            echo '</div>';

                            // Formularz dodawania komentarzy
                            echo '<div class="post-comment">';
                            echo '<form action="add_comment.php" method="post">';
                            echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
                            echo '<input type="text" name="author_name" placeholder="Twoja Nazwa" required>';
                            echo '<input type="text" name="content" placeholder="Napisz komentarz" required>';
                            echo '<input type="submit" value="Comment">';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "Brak postów.";
                    }
                    $conn->close();
                    ?>
                </div>
            </div>
            <div class="sidebar">
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
</body>
</html>
