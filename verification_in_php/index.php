<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>
<body>
    <form action="register.php" method="POST">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Submit</button>
    </form>
</body>
</html>


<?php
$servername = "localhost";
$username = "";
$password = "'";
$dbname = "'";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(50)); // Generate a random token

    $sql = "INSERT INTO users (id, email, password, token, verified) VALUES ('$id', '$email', '$password', '$token', 0)";
    if ($conn->query($sql) === TRUE) {
        // Send verification email
        $verificationLink = "http://yourdomain.com/verify.php?email=$email&token=$token";
        $subject = "Email Verification";
        $message = "Click this link to verify your email: $verificationLink";
        $headers = "From: noreply@yourdomain.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "Verification email sent to $email";
        } else {
            echo "Failed to send verification email.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>


<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    $sql = "SELECT * FROM users WHERE email='$email' AND token='$token' AND verified=0";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sql = "UPDATE users SET verified=1 WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            echo "Email verified successfully!";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid verification link or email already verified.";
    }
}
$conn->close();
?>


<script>
        let sessionCount = 0;
        const maxSessions = 2;

        function startSession() {
            sessionCount++;
            if (sessionCount > maxSessions) {
                alert("Session limit reached. Logging out.");
                window.location.href = 'logout.php';
            }
        }

        window.onload = function() {
            startSession();
        };
    </script>