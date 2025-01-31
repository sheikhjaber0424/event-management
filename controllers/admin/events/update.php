<?php
require_once('core/functions.php');
require('core/Database.php');


$eventId = $_GET['id'] ?? null;

if (!$eventId) {
    header('Location: /admin/events');
    exit();
}

// Database connection setup
$config = require('core/config.php');
$db = new Database($config['database']);

// Fetch the event data
$event = $db->query("SELECT * FROM events WHERE id = :id", [':id' => $eventId])->fetch();

if (!$event) {
    // Redirect to the events list if the event doesn't exist
    $_SESSION['message'] = 'Event not found.';
    $_SESSION['message_type'] = 'danger';
    header('Location: /admin/events');
    exit();
}

// Handle form submission
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

    // Validation (same as before)
    if (empty($name)) {
        $errors['name'] = 'Event name is required.';
    } elseif (strlen($name) > 255) {
        $errors['name'] = 'Event name cannot exceed 255 characters.';
    }

    if (empty($description)) {
        $errors['description'] = 'Event description is required.';
    } elseif (strlen($description) > 2000) {
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

    // If there are validation errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: /admin/events/edit?id=' . $eventId);
        exit();
    }

    // Process file upload (optional)
    $imagePath = $event['image']; // Keep the existing image by default
    if ($image && $image['error'] === UPLOAD_ERR_OK) {
        $imageType = mime_content_type($image['tmp_name']);
        if (strpos($imageType, 'image') === false) {
            $_SESSION['errors']['image'] = 'Uploaded file is not an image.';
            header('Location: /admin/events/edit?id=' . $eventId);
            exit();
        }

        $uploadDir = 'public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Delete the previous image if it exists
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $imageName = uniqid('event_', true) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

        if (!move_uploaded_file($image['tmp_name'], $uploadDir . $imageName)) {
            $_SESSION['errors']['image'] = 'Failed to upload image.';
            header('Location: /admin/events/edit?id=' . $eventId);
            exit();
        }

        $imagePath = $uploadDir . $imageName;
    }

    // Define the params array
    $params = [
        ':id' => $eventId,
        ':name' => $name,
        ':description' => $description,
        ':date' => $date,
        ':capacity' => $capacity,
        ':location' => $location,
        ':image' => $imagePath,
    ];

    // Prepare the SQL query
    $query = "UPDATE events 
              SET name = :name, description = :description, date = :date, 
                  capacity = :capacity, location = :location, image = :image 
              WHERE id = :id";

    // Execute the query
    if ($db->query($query, $params)) {
        $_SESSION['message'] = 'Event updated successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Failed to update event';
        $_SESSION['message_type'] = 'danger';
    }

    // Redirect back to the edit page
    header('Location: /admin/events');
    exit();
}
