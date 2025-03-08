<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_tuition";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data and sanitize it
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // Ensure none of the fields are empty
    if(!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Insert data into the database
        $sql = "INSERT INTO contact_form (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

        if ($conn->query($sql) === TRUE) {
            echo "Thank you! Your message has been received.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "All fields are required!";
    }

    // Close the connection
    $conn->close();
}
?>
