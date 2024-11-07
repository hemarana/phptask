<?php
// database details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "task_php";

// creating a connection
$con = mysqli_connect($host, $username, $password, $dbname);

// to ensure that the connection is made
if (!$con) {
    die("Connection failed!" . mysqli_connect_error());
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// $mailSent = mail("hemahabitat@gmail.com", "test php", "hello body msg", "this mail sentsfsf");


// if ($mailSent) {
//     echo "Success: Email sent successfully.";
// } else {
//     echo "Error: Failed to send email.";
// }

?>
<!DOCTYPE html>
<html>

<head>

</head>
<?php
// getting all values from the HTML form
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];


    // $sql = "INSERT INTO data (name, phone, email) VALUES ($name, $phone ,   $email)";

    // $query = "INSERT INTO `data`(`name`, `phone`, `email`) VALUES ('[$name]','[$phone]','[$email]')";

    $query = "INSERT INTO `data`(`name`, `phone`, `email`) VALUES ('$name', '$phone', '$email')";

    // send query to the database to add values and confirm if successful
    $rs = mysqli_query($con, $query);
    if ($rs) {
        echo "Entries added!";
    }


    // close connection
    mysqli_close($con);
}
?>

<body>

</body>
<form method="POST" action="">
    <input type="text" name="name" placeholder="name" required>
    <input type="text" name="phone" placeholder="phone" required>
    <input type="email" name="email" placeholder="email" required>
    <input type="submit" name="submit">
</form>

</html>