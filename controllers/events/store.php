<?php
require_once('core/functions.php');
require('core/Database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize error array
    $errors = [];

    // Get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $capacity = $_POST['capacity'];
    $location = $_POST['location'] ?? null;  // Optional field
    $image = $_FILES['image'] ?? null;  // Optional image file

    if (empty($name)) {
        $errors['name'] = 'Event name is required.';
    } elseif (strlen($name) > 255) {
        $errors['name'] = 'Event name cannot exceed 255 characters.';
    }

    if (empty($description)) {
        $errors['description'] = 'Event description is required.';
    } elseif (strlen($description) > 2000) { // Assuming a reasonable limit
        $errors['description'] = 'Event description cannot exceed 2000 characters.';
    }

    if (empty($date)) {
        $errors['date'] = 'Event date is required.';
    }

    if (empty($capacity)) {
        $errors['capacity'] = 'Event capacity is required.';
    } elseif (!is_numeric($capacity) || (int)$capacity < 1) {
        $errors['capacity'] = 'Capacity must be a valid number greater than 0.';
    }

    if (!empty($location) && strlen($location) > 255) {
        $errors['location'] = 'Location cannot exceed 255 characters.';
    }

    // If there are any validation errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: /admin/events/create');
        exit();
    }

    // Process file upload (optional)
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $imageType = mime_content_type($image['tmp_name']);
        if (strpos($imageType, 'image') === false) {
            $_SESSION['errors']['image'] = 'Uploaded file is not an image.';
            header('Location: /admin/events/create');
            exit();
        }

        $uploadDir = 'public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imageName = uniqid('event_', true) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

        if (!move_uploaded_file($image['tmp_name'], $uploadDir . $imageName)) {
            $_SESSION['errors']['image'] = 'Failed to upload image.';
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
