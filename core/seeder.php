<?php

require_once('Database.php');

$config = require_once('config.php');
$db = new Database($config['database']);

try {
    // Create Users Table
    $db->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        is_admin TINYINT(1) DEFAULT 3,  
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Create Events Table
    $db->query("CREATE TABLE IF NOT EXISTS events (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        date DATE NOT NULL,
        capacity INT NOT NULL,
        registration_count INT DEFAULT 0,
        location VARCHAR(255) NOT NULL,
        image VARCHAR(255) DEFAULT NULL,
        is_full TINYINT(1) DEFAULT 0, 
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Create Event Registration Table (Many-to-Many)
    $db->query("CREATE TABLE IF NOT EXISTS event_registration (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        event_id INT NOT NULL,
        tickets INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
    )");

    // Insert Default Users (Check if they exist first)
    $existingUsers = $db->query("SELECT COUNT(*) as count FROM users")->fetch();
    if ($existingUsers['count'] == 0) {
        $db->query("INSERT INTO users (name, email, password, is_admin) VALUES
            ('Super Admin', 'super@admin.com', '" . password_hash('super1234', PASSWORD_BCRYPT) . "', 1),
            ('Admin', 'admin@gmail.com', '" . password_hash('admin1234', PASSWORD_BCRYPT) . "', 2),
            ('Attendee', 'attendee@gmail.com', '" . password_hash('attendee1234', PASSWORD_BCRYPT) . "', 3)
        ");
        echo "Users successfully inserted!\n";
    } else {
        echo "Users already exist, skipping insertion.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
