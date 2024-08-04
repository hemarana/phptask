<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Sheets;

$client = new Client();
$client->setAuthConfig(__DIR__ . '/calcium-doodad-430107-r6-f655e0231a76.json');
$client->addScope(Sheets::SPREADSHEETS);

// ID of the Google Spreadsheet
$spreadsheetId = '19tnIOLOcBbQ0Okxu2p_WjPYN7rpffLwofwVeeCtbXYY';

// Connect to Google Sheets
$service = new Sheets($client);

function verifyEmail($service, $spreadsheetId, $email, $token) {
    $range = 'Sheet1'; // Name of the sheet
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    if (empty($values)) {
        return "Invalid verification link or email already verified.";
    } else {
        foreach ($values as $index => $row) {
            if ($row[0] == $email && $row[2] == $token && $row[3] == '0') {
                $values[$index][3] = '1'; // Mark as verified
                $body = new Sheets\ValueRange([
                    'values' => $values
                ]);
                $params = [
                    'valueInputOption' => 'RAW'
                ];
                $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
                return "Email verified successfully!";
            }
        }
    }
    return "Invalid verification link or email already verified.";
}

function verifyEmailInMySQL($email, $token) {
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND token = ? AND verified = 0");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE users SET verified = 1 WHERE email = ? AND token = ?");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        return "Email verified successfully!";
    } else {
        $stmt->close();
        $conn->close();
        return "Invalid verification link or email already verified.";
    }
}

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    $message = verifyEmail($service, $spreadsheetId, $email, $token);

    if ($message == "Email verified successfully!") {
        // Verify in MySQL
        $message = verifyEmailInMySQL($email, $token);
    }

    echo $message;
} else {
    echo "Invalid request.";
}
?>
