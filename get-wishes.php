<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once 'config.php';

try {
    // Works with MySQL, PostgreSQL, and SQLite
    $stmt = $pdo->query("SELECT * FROM wishes ORDER BY created_at DESC LIMIT 50");
    $wishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($wishes);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch wishes: ' . $e->getMessage()]);
}
?>