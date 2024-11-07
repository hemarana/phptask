<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$to = "recipient@example.com";
$subject = "Test Email";
$message = "This is a test email.";
$headers = "From: sender@example.com";

// Sending email
if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
} else {
    $last_error = error_get_last();
    if ($last_error !== null && isset($last_error['message'])) {
        echo "Email sending failed. Error: " . $last_error['message'];
    } else {
        echo "Email sending failed.";
    }
}
?>
