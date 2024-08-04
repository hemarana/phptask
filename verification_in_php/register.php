<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;

$client = new Client();
$client->setAuthConfig(__DIR__ . '/calcium-doodad-430107-r6-f655e0231a76.json'); 
$client->addScope(Sheets::SPREADSHEETS);

// ID of the Google Spreadsheet
$spreadsheetId = '19tnIOLOcBbQ0Okxu2p_WjPYN7rpffLwofwVeeCtbXYY';

$service = new Sheets($client);

function addToGoogleSheet($service, $spreadsheetId, $email, $password, $token) {
    $range = 'Sheet1';
    $values = [
        [$email, $password, $token, '0']
    ];
    $body = new Sheets\ValueRange([
        'values' => $values
    ]);
    $params = [
        'valueInputOption' => 'RAW'
    ];
    $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
}

function addToMySQL($email, $password, $token) {
    $servername = "localhost";
    $username = "";
    $dbpassword = "";
    $dbname = "";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists
        $stmt->close();
        $conn->close();
        return false; // Or you can return a specific message
    }

    // Insert new record
    $stmt = $conn->prepare("INSERT INTO users (email, password, token, verified) VALUES (?, ?, ?, ?)");
    $verified = 0;
    $stmt->bind_param("sssi", $email, $password, $token, $verified);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    return true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(50));

    if (addToMySQL($email, $password, $token)) {
        addToGoogleSheet($service, $spreadsheetId, $email, $password, $token);

        $verificationLink = "https://phptask.earthenwarearoma.com/testcode/verify.php?email=$email&token=$token";
        $subject = "Email Verification";
        $message = "Click this link to verify your email: $verificationLink";
        $headers = "From: noreply@earthenwarearoma.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "Verification email sent to $email";
        } else {
            echo "Failed to send verification email.";
        }
    } else {
        echo "Email already exists.";
    }
}
?>
