<?php

require_once('core/functions.php');
require('core/Database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $capacity = $_POST['capacity'];
    $location = $_POST['location'] ?? null;  // Optional field
    $image = $_FILES['image'] ?? null;  // Optional image file

    // Validate input (basic validation)
    if (empty($name) || empty($description) || empty($date) || empty($capacity)) {
        $_SESSION['message'] = 'Please fill in all required fields.';
        $_SESSION['message_type'] = 'danger';
        header('Location: /admin/events/create');
        exit();
    }

    // Process file upload
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $imageType = mime_content_type($image['tmp_name']);
        if (strpos($imageType, 'image') === false) {
            $_SESSION['message'] = 'Uploaded file is not an image.';
            $_SESSION['message_type'] = 'danger';
            header('Location: /admin/events/create');
            exit();
        }

        $uploadDir = 'public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageName = uniqid('_event_', true) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

        if (!move_uploaded_file($image['tmp_name'], $uploadDir . $imageName)) {
            $_SESSION['message'] = 'Failed to upload image.';
            $_SESSION['message_type'] = 'danger';
            header('Location: /admin/events/create');
            exit();
        }

        $imagePath = $uploadDir . $imageName;
    } else {
        $imagePath = null; // No image uploaded
    }

    // Database connection setup
    $config = require('core/config.php');
    $db = new Database($config['database']);

    // Define the params array
    $params = [
        ':name' => $name,
        ':description' => $description,
        ':date' => $date,
        ':capacity' => $capacity,
        ':location' => $location,
        ':image' => $imagePath
    ];

    // Prepare the SQL query
    $query = "INSERT INTO events (name, description, date, capacity, location, image) 
              VALUES (:name, :description, :date, :capacity, :location, :image)";

    // Execute the query
    if ($db->query($query, $params)) {
        $_SESSION['message'] = 'Event created successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Failed to create event';
        $_SESSION['message_type'] = 'danger';  // 'danger' is commonly used for errors
    }

    // Redirect to the event creation page after form submission
    header('Location: /admin/events/create');
    exit();
}
