<?php
require_once('core/functions.php');
require('core/Database.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize error array
    $errors = [];
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['is_admin']; // User type (1, 2, or 3)
    // Validate name
    if (empty($name)) {
        $errors['name'] = 'Name is required.';
    } elseif (strlen($name) > 255) {
        $errors['name'] = 'Name cannot exceed 255 characters.';
    }
    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }
    // Validate password
    if (empty($password)) {
        $errors['password'] = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long.';
    }
    // Validate user type
    if (empty($userType) || !in_array($userType, [1, 2, 3])) {
        $errors['is_admin'] = 'Please select a valid user type.';
    }
    // If there are any validation errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: /admin/users/create');
        exit();
    }
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    // Database connection setup
    $config = require('core/config.php');
    $db = new Database($config['database']);
    // Check if the email already exists in the database
    $user = $db->query("SELECT * FROM users WHERE email = ?", [$email])->fetch();
    if ($user) {
        $_SESSION['errors']['email'] = 'Email is already registered.';
        header('Location: /admin/users/create');
        exit();
    }
    // Define the params array
    $params = [
        ':name' => $name,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':is_admin' => $userType,
    ];
    // Prepare the SQL query
    $query = "INSERT INTO users (name, email, password, is_admin) 
              VALUES (:name, :email, :password, :is_admin)";
    // Execute the query
    if ($db->query($query, $params)) {
        $_SESSION['message'] = 'User created successfully!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Failed to create user';
        $_SESSION['message_type'] = 'danger';  // 'danger' is commonly used for errors
    }
    // Redirect to the user creation page after form submission
    header('Location: /admin/users/create');
    exit();
}
