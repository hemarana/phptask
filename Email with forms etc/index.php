<?php
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg, 70);
$header = "From:your@gmail.com \r\n";
$header .= "Cc:your@gmail.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";


//  send email
/* $result = mail ("hema@gmail.com","My subject",$msg, $header);
if( $result == true ){
  echo 'send ' ; 
 }
  else
{
    echo 'send not' ;
}
*/
?>
<br>



<?php
$to = "yours@gmail.com, hema@gmail.com, your@gmail.com, hemagrow@gmail.com";
$subject = "This is subject";

$message = "<b>This is HTML message.</b>";
$message .= "<h1>This is headline.</h1>";

$header = "From:abc@somedomain.com \r\n";
$header .= "Cc:afgh@somedomain.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n"; // support html tag

/*   $retval = mail ($to,$subject,$message,$header);
   
   if( $retval == true ) {
      echo "Message sent successfully...";
   }else {
      echo "Message could not be sent...";
   }
   */
?>

<html>


<boyd>


   <?php
   if (isset($_POST['submit'])) {
      $to = "hema@gmail.com"; // this is your Email address
      $from = $_POST['email']; // this is the sender's Email address
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $subject = "Form submission";
      $subject2 = "Copy of your form submission";
      $message = $first_name . " " . $last_name . " wrote the following:" . "\n\n" . $_POST['message'];
      $message2 = "Here is a copy of your message " . $first_name . "\n\n" . $_POST['message'];

      $headers = "From:" . $from;
      $headers2 = "From:" . $to;
      mail($to, $subject, $message, $headers);
      mail($from, $subject2, $message2, $headers2); // sends a copy of the message to the sender
      echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
      // You can also use header('Location: thank_you.php'); to redirect to another page.
   }
   ?>

   <!DOCTYPE html>

   <head>
      <title>Form submission</title>
   </head>

   <body>

      <form action="" method="post">
         First Name: <input type="text" name="first_name"><br>
         Last Name: <input type="text" name="last_name"><br>
         Email: <input type="text" name="email"><br>
         Message:<br><textarea rows="5" name="message" cols="30"></textarea><br>
         <input type="submit" name="submit" value="Submit">
      </form>


   </body>

</html>