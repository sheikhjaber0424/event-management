<?php

require_once('Database.php');

$config = require_once('config.php');
$db = new Database($config['database']);

try {
    $result = $db->query("INSERT INTO users (name, email, password, is_admin) VALUES
    ('Super Admin', 'super@admin.com', '" . password_hash('super1234', PASSWORD_BCRYPT) . "', 1),
    ('Admin', 'admin@gmail.com', '" . password_hash('admin1234', PASSWORD_BCRYPT) . "', 2),
    ('Attendee', 'attendee@gmail.com', '" . password_hash('attendee1234', PASSWORD_BCRYPT) . "', 3)
    ");

    if ($result) {
        echo "Users successfully inserted!";
    } else {
        throw new Exception("Failed to insert users.");
    }
} catch (Exception $e) {
    echo "Error inserting users: " . $e->getMessage();
}
