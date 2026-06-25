<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$name = trim($data['name'] ?? '');
$birthday = trim($data['birthday'] ?? '');
$message = trim($data['message'] ?? '');

if (empty($name) || empty($birthday) || empty($message)) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields required']);
    exit;
}

try {
    // Detect if using SQLite or other
    $db_type = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    
    if ($db_type === 'pgsql' || $db_type === 'mysql') {
        $stmt = $pdo->prepare("INSERT INTO wishes (name, birthday, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $birthday, $message]);
        $id = $pdo->lastInsertId();
    } else {
        // SQLite
        $stmt = $pdo->prepare("INSERT INTO wishes (name, birthday, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $birthday, $message]);
        $id = $pdo->lastInsertId();
    }
    
    echo json_encode([
        'success' => true,
        'id' => $id
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save wish: ' . $e->getMessage()]);
}
?>