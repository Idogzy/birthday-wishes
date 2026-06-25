-- Database schema for Birthday Wisher
-- Works with both MySQL and PostgreSQL

-- For MySQL
CREATE TABLE IF NOT EXISTS wishes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    birthday VARCHAR(10) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- For PostgreSQL (Render uses this)
-- Uncomment if using PostgreSQL locally
/*
CREATE TABLE IF NOT EXISTS wishes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    birthday VARCHAR(10) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
*/

-- Insert sample data
INSERT INTO wishes (name, birthday, message) VALUES 
('John', '12/25', 'Happy Birthday, John! 🎂 Wishing you a fantastic day!'),
('Jane', '06/15', 'Happy Birthday, Jane! 🎉 You''re amazing!');