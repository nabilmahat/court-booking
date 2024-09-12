<?php
session_start();
include '../connection/connection.php'; // Include your database connection details

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Check if inputs are not empty
    if (!empty($username) && !empty($password)) {
        // Prepare and execute the query
        $sql = "SELECT id, password FROM users WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->bind_result($userId, $hashedPassword);
            $stmt->fetch();
            $stmt->close();

            // Verify password
            // if (password_verify($password, $hashedPassword)) {
            if ($password == $hashedPassword) {
                // Password is correct, start a session
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $username;

                // Redirect to booking list page
                header("Location: ../admin.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Database query failed.";
        }
    } else {
        $error = "Please enter username and password.";
    }
}

$conn->close();
?>