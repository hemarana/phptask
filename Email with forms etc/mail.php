<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  $to = "hema@gmail.com";
  $subject = $message;
  $body = "
  <!DOCTYPE html>
  <html>
  <head>
    <title>New message from" . $name . "</title>
  </head>
  <body>
    <h1>Hi,</h1>
    <p>You have received a new message from $name.</p>
    <p>Here is the message:</p>
    <p>Name: $name</p>
    <p>Email: $email</p>
    <p>Message: $message</p>
  </body>
  </html>
 ";

 $headers = "MIME-Version: 1.0" . "\r\n";
 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

  if (mail($to, $subject, $body, $headers)) {
    echo "success";
  } 
  else {
    echo "error";
  }
}
?>

<html>
<head>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   </head>
<body>
<div id="successMessage" style="display:none;">Your message has been submitted. Our team will contact you.</div>
<form  id="frmContactus">
  <input type="text" name="name" placeholder="Your name">
  <input type="text" name="email" placeholder="Your email address">
  <textarea name="message" placeholder="Your message"></textarea>
  <input type="submit" value="Submit" id="submit" name="submit">
  <span style="color:red;" id="msg"></span>
</form>

</body>
<script>
  $(document).ready(function(){
	  $('#frmContactus').on('submit',function(e){
		$('#msg').html('');
		$('#submit').html('Please wait');
		$('#submit').attr('disabled',true);
		jQuery.ajax({
			url:'mail.php',
			type:'POST',
			data:jQuery('#frmContactus').serialize(),
			success:function(result){
				$('#msg').html(result);
				$('#submit').html('Submit');
				$('#submit').attr('disabled',false);
				$('#frmContactus')[0].reset();
			}
		});
		e.preventDefault();
	  });
  });
	  </script>
</html>
