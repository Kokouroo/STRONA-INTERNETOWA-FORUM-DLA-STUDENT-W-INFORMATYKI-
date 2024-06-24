<?php
// Połączenie z bazą danych MySQL
$host = 'localhost';
$dbname = 'procesowniadb';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Nie można połączyć się z bazą danych: " . $e->getMessage());
}

// Pobranie wartości kategorii z parametrów POST
$category = $_POST['category'];

// Funkcja do pobierania linków z bazy danych na podstawie kategorii
function getLinksByCategory($pdo, $category) {
    $sql = "SELECT id, nazwa, link FROM zasoby WHERE kategoria = :category";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':category', $category, PDO::PARAM_INT);
    $stmt->execute();

    // Zwrócenie wyników jako HTML
    $output = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $output .= '<div>';
        $output .= '<h3>' . htmlspecialchars($row['nazwa']) . '</h3>';
        $output .= '<iframe width="560" height="315" src="' . htmlspecialchars($row['link']) . '" frameborder="0" allowfullscreen></iframe>';
        $output .= '</div>';
    }
    echo $output;
}

// Wywołanie funkcji dla danej kategorii
getLinksByCategory($pdo, $category);
?>