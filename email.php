<?php
// Define variables
$to = "yourmail@gmail.com";
$subject = "Message from Website";
$header = "From: I am growing\r\n"; // Change to your business name
$header .= "MIME-Version: 1.0\r\n"; // Support HTML tags
$header .= "Content-type: text/html\r\n"; // Support HTML tags

$name = "User"; // Replace with actual name variable if available
$email = "yourmail@example.com"; // Replace with actual email variable if available
$message_content = "This is the message content"; // Replace with actual message content variable if available

$message = "
<html>
<head>
<title>Hello $name</title>
</head>
<body>
<img src='https://static.pexels.com/photos/36753/flower-purple-lical-blosso.jpg' style='width:100%'>
<p>This email contains HTML tags!</p>
<table>
<tr>
<th>Hello $name, see I told you $message_content</th>
<th>Lastname</th>
</tr>
<tr>
<td>Email: $email</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

// Send the email
if(mail($to, $subject, $message, $header)){
    echo "Mail has been sent";
} else {
    echo "Mail sending failed";
}

// Send thank you email to the user
$receiver_to = $email;
$receiver_subject = "Thank You for Contacting Us";
$receiver_header = "From: yourmail@gmail.com\r\n"; // Replace with your email
$receiver_header .= "MIME-Version: 1.0\r\n";
$receiver_header .= "Content-type: text/html\r\n";

$thankYouMessage = "
<html>
<head>
<title>Thank You</title>
</head>
<body>
<h1>Thank You for Contacting Us</h1>
<p>We have received your message and will get back to you as soon as possible.</p>
</body>
</html>
";

// Send the thank you email
mail($receiver_to, $receiver_subject, $thankYouMessage, $receiver_header);
?>
