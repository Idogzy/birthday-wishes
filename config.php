<?php
// config.php - Auto-detects environment and database type

// Check if we're on Render (has DATABASE_URL environment variable)
$database_url = getenv('DATABASE_URL');

// Function to get database connection
function getConnection() {
    global $database_url;
    
    // Check for Render PostgreSQL
    if ($database_url) {
        try {
            $db = parse_url($database_url);
            $host = $db['host'];
            $port = $db['port'] ?? '5432';
            $dbname = ltrim($db['path'], '/');
            $username = $db['user'];
            $password = $db['pass'];
            
            $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $pdo->exec("
                CREATE TABLE IF NOT EXISTS wishes (
                    id SERIAL PRIMARY KEY,
                    name VARCHAR(100) NOT NULL,
                    birthday VARCHAR(10) NOT NULL,
                    message TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ");

            $stmt = $pdo->query("SELECT COUNT(*) FROM wishes");
            if ($stmt->fetchColumn() == 0) {
                $pdo->exec("
                    INSERT INTO wishes (name, birthday, message) VALUES
                    ('John', '12/25', 'Happy Birthday, John! Wishing you a fantastic day!'),
                    ('Jane', '06/15', 'Happy Birthday, Jane! You are amazing!')
                ");
            }

            return $pdo;
        } catch(PDOException $e) {
            die(json_encode(['error' => 'Render DB connection failed: ' . $e->getMessage()]));
        }
    }
    
    // Check for local .env file
    if (file_exists(__DIR__ . '/.env')) {
        $env = parse_ini_file(__DIR__ . '/.env');
        $db_type = $env['DB_TYPE'] ?? 'mysql';
        
        // Try MySQL
        if ($db_type === 'mysql') {
            try {
                $pdo = new PDO(
                    "mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']};charset=utf8",
                    $env['DB_USER'],
                    $env['DB_PASS']
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $pdo->exec("
                    CREATE TABLE IF NOT EXISTS wishes (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(100) NOT NULL,
                        birthday VARCHAR(10) NOT NULL,
                        message TEXT NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )
                ");

                $stmt = $pdo->query("SELECT COUNT(*) FROM wishes");
                if ($stmt->fetchColumn() == 0) {
                    $pdo->exec("
                        INSERT INTO wishes (name, birthday, message) VALUES
                        ('John', '12/25', 'Happy Birthday, John! Wishing you a fantastic day!'),
                        ('Jane', '06/15', 'Happy Birthday, Jane! You are amazing!')
                    ");
                }

                return $pdo;
            } catch(PDOException $e) {
                // Fallback to SQLite if MySQL fails
                return getSQLiteConnection();
            }
        }
    }
    
    // Try SQLite as ultimate fallback (no database server needed!)
    return getSQLiteConnection();
}

// SQLite fallback connection
function getSQLiteConnection() {
    try {
        $db_file = __DIR__ . '/birthday_wishes.db';
        // Create SQLite database if it doesn't exist
        if (!file_exists($db_file)) {
            $pdo = new PDO("sqlite:$db_file");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create table
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS wishes (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name VARCHAR(100) NOT NULL,
                    birthday VARCHAR(10) NOT NULL,
                    message TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ");
            
            // Insert sample data
            $pdo->exec("
                INSERT OR IGNORE INTO wishes (name, birthday, message) VALUES 
                ('John', '12/25', 'Happy Birthday, John! 🎂 Wishing you a fantastic day!'),
                ('Jane', '06/15', 'Happy Birthday, Jane! 🎉 You''re amazing!')
            ");
            
            return $pdo;
        }
        
        $pdo = new PDO("sqlite:$db_file");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// Get the connection
$pdo = getConnection();
?>