<?php
include('db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Delete record
if(isset($_GET['delete'])){
    $id = mysqli_real_escape_string($con, $_GET['delete']);
    mysqli_query($con, "DELETE FROM $table WHERE Id=$id");
    echo 'success';
    exit();
}

// Update record
if(isset($_POST['update_id']) && isset($_POST['update_name']) && isset($_POST['update_email']) && isset($_POST['update_message'])){
    $id = mysqli_real_escape_string($con, $_POST['update_id']);
    $name = mysqli_real_escape_string($con, $_POST['update_name']);
    $email = mysqli_real_escape_string($con, $_POST['update_email']);
    $message = mysqli_real_escape_string($con, $_POST['update_message']);

    $update = mysqli_query($con, "UPDATE $table SET name='$name', email='$email', msg='$message' WHERE Id=$id");
    if ($update) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
    exit();
}

// Insert new record
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message_content = mysqli_real_escape_string($con, $_POST['message']);

    $insert = mysqli_query($con, "INSERT INTO $table (name, email, msg) VALUES ('$name', '$email', '$message_content')");
    if ($insert) {
        // Send email to admin
        $to = "yourmail@example.com";
        $subject = "Message from Website";
        $header = "From: I am growing\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";

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

        mail($to, $subject, $message, $header);

        // Send thank you email to the user
        $receiver_to = $email;
        $receiver_subject = "Thank You for Contacting Us";
        $receiver_header = "From: yourmail@example.com\r\n";
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

        mail($receiver_to, $receiver_subject, $thankYouMessage, $receiver_header);

        echo "New record created successfully";
    } else {
        echo "Error inserting record: " . mysqli_error($con);
    }
}

// Fetch all records
$data = "SELECT * FROM $table";
$result = mysqli_query($con, $data);

echo "<table border='1' style='border-collapse: collapse; width:100%'>";
while($row = mysqli_fetch_assoc($result)){
    echo "
    <tr>
    <td>{$row['Id']}</td>
    <td>{$row['name']}</td>
    <td>{$row['email']}</td>
    <td>{$row['msg']}</td>
    <td><button class='update' data-id='{$row['Id']}' data-name='{$row['name']}' data-email='{$row['email']}' data-message='{$row['msg']}'>Update</button></td>
    <td><button class='delete' id='{$row['Id']}'>Delete</button></td>
    </tr>
    ";
}
echo "</table>";
?>

<html>
<head>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<div id="successMessage" style="display:none;">Your message has been submitted. Our team will contact you.</div>
<form id="contactform" method="POST">
    <input type="text" name="name" placeholder="Your name" required>
    <input type="email" name="email" placeholder="Your email address" required>
    <textarea name="message" placeholder="Your message" required></textarea>
    <input type="submit" value="Submit" id="submit" name="submit">
    <span style="color:red;" id="msg"></span>
</form>

<!-- Update Modal -->
<div id="updateModal" style="display:none;">
    <form id="updateform">
        <input type="hidden" name="update_id" id="update_id">
        <input type="text" name="update_name" id="update_name" placeholder="Your name" required>
        <input type="email" name="update_email" id="update_email" placeholder="Your email address" required>
        <textarea name="update_message" id="update_message" placeholder="Your message" required></textarea>
        <input type="submit" value="Update" id="update_submit">
    </form>
</div>

<script>
$(document).ready(function(){
    $('#contactform').on('submit', function(e){
        e.preventDefault();
        $('#submit').html('Please wait').attr('disabled', true);
        
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: $('#contactform').serialize(),
            success:function(response){
                $('#submit').html('Submit').attr('disabled', false);
                $('#contactform')[0].reset();
                $('#successMessage').show();
                console.log(response); // for debugging purposes
            }
        });
    });

    $(".delete").on('click', function(){
        var id = this.id;
        var element = $(this);
        $.ajax({
            url: 'index.php',
            type: 'GET',
            data: {'delete':id},
            success:function(response){
                if(response === 'success'){
                    element.closest('tr').remove();
                }
            }
        });
    });

    $(".update").on('click', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var message = $(this).data('message');

        $('#update_id').val(id);
        $('#update_name').val(name);
        $('#update_email').val(email);
        $('#update_message').val(message);

        $('#updateModal').show();
    });

    $('#updateform').on('submit', function(e){
        e.preventDefault();
        $('#update_submit').html('Please wait').attr('disabled', true);
        
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: $('#updateform').serialize(),
            success:function(response){
                $('#update_submit').html('Update').attr('disabled', false);
                $('#updateform')[0].reset();
                $('#updateModal').hide();
                console.log(response); // for debugging purposes
            }
        });
    });
});
</script>
</body>
</html>
