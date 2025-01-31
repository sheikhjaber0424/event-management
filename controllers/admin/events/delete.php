<?php



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $eventId = $_POST['id'];

    // Database connection
    require('core/Database.php');
    $config = require('core/config.php');
    $db = new Database($config['database']);

    // Fetch the event details to check if an image exists
    $query = "SELECT image FROM events WHERE id = :id";
    $params = [':id' => $eventId];
    $event = $db->query($query, $params)->fetch();

    // If the event has an image, delete the image from the server
    if (!empty($event['image'])) {
        $imagePath = $event['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);  // Delete the image file
        }
    }

    // Prepare and execute the deletion query for the event
    $query = "DELETE FROM events WHERE id = :id";
    $params = [':id' => $eventId];

    if ($db->query($query, $params)) {
        $_SESSION['message'] = 'Event deleted successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Failed to delete event.';
        $_SESSION['message_type'] = 'danger';
    }

    // Redirect back to the events listing page
    header('Location: /admin/events');
    exit();
}
