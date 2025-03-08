<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include Firebase dependencies
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

// Firebase configuration
$factory = (new Factory)
    ->withServiceAccount(__DIR__ . '/firebase_credentials.json')
    ->withDatabaseUri('https://smarttuition-b5b49-default-rtdb.firebaseio.com');

$database = $factory->createDatabase();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data and sanitize it
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Ensure none of the fields are empty
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        // Create a data array
        $data = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'timestamp' => time()
        ];

        // Store data in Firebase Realtime Database
        $reference = $database->getReference('contact_form')->push($data);
        
        if ($reference) {
            echo "Thank you! Your message has been received.";
        } else {
            echo "Error storing data in Firebase.";
        }
    } else {
        echo "All fields are required!";
    }
}
?>
