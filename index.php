<?php
require 'vendor/autoload.php';

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;

// Create Secrets Manager client
$client = new SecretsManagerClient([
    'version' => 'latest',
    'region' => 'ap-south-1' // your region
]);

$secretName = 'php-dev-secrets';

try {
    $result = $client->getSecretValue([
        'SecretId' => $secretName,
    ]);

    if (isset($result['SecretString'])) {
        $secret = json_decode($result['SecretString'], true);

        $host = $secret['DB_HOST'];
        $db   = 'bookstore';
        $user = $secret['DB_USER'];
        $pass = $secret['DB_PASS'];
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        echo "<h3>✅ Connected to MySQL database successfully!</h3>";

        $stmt = $pdo->query("SELECT id, title, author FROM books");

        echo "<h4>📚 Books List:</h4><ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li><strong>{$row['title']}</strong> by {$row['author']}</li>";
        }
        echo "</ul>";

    } else {
        throw new Exception("SecretString not found");
    }

} catch (AwsException $e) {
    echo "<h3>❌ AWS Error: " . $e->getAwsErrorMessage() . "</h3>";
} catch (PDOException $e) {
    echo "<h3>❌ Database connection failed: " . $e->getMessage() . "</h3>";
} catch (Exception $e) {
    echo "<h3>❌ Error: " . $e->getMessage() . "</h3>";
}
?>
