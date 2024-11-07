<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
</head>
<body>

  <h1>Contact Us</h1>

  <form method="POST" action="">
    <!-- Capture the current page URL -->
    <input 
      type="hidden" 
      name="page_url" 
      value="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER'] ?? ''); ?>" 
    />

    <input type="text" name="name" placeholder="Your Name" required />
    <input type="email" name="email" placeholder="Your Email" required />
    <textarea name="message" placeholder="Your Message" required></textarea>

    <button type="submit">Submit</button>
  </form>

</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form input data
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);
    $page_url = htmlspecialchars($_POST['page_url']);

    // Example: Send an email with the contact form details
    $to = 'hema@gmail.com';  // Replace with your admin email
    $subject = "New Contact Form Submission from $name";
    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message: $message\n";
    $body .= "Form submitted from: $page_url\n";

    $headers = "From: $email\r\n";
    
    if (mail($to, $subject, $body, $headers)) {
        echo "Thank you, $name! Your message has been sent.";
    } else {
        echo "Sorry, something went wrong. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
