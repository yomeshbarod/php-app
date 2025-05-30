index.php
<?php
$host = '172.31.2.53';  // or 'database' if using Docker
$db   = 'bookstore';
$user = 'yomesh';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    echo "<h3>✅ Connected to MySQL database successfully!</h3>";

    // Sample SELECT query
    $stmt = $pdo->query("SELECT id, title, author FROM books");

    echo "<h4>📚 Books List:</h4><ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li><strong>{$row['title']}</strong> by {$row['author']}</li>";
    }
    echo "</ul>";

} catch (PDOException $e) {
    echo "<h3>❌ Database connection failed: " . $e->getMessage() . "</h3>";
}
?>
