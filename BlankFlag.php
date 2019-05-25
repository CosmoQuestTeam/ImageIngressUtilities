<?php
/**
 * Created by PhpStorm.
 * User: starstryder
 * Date: 5/25/19
 * Time: 2:12 PM
 */

// Connect to Database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Look for cases where there are no marks for a given image_users id, set the details to 'blank submission'
// ONLY USE IMAGE SETS WITH image_set_it > 4200. These are images with id >=  41228380

$sql = "SELECT id FROM image_users WHERE image_id >= 41228380";
$result = mysqli_query($conn, $sql);
while($submission = mysqli_fetch_assoc($result)) {

    // Look in the marks file and see if anything is submitted
    $sql = "SELECT id FROM marks WHERE image_user_id = ".$submission['id'];
    $result2 = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result2) == 0) {
        $sql = "UPDATE image_users SET details = 'blank submission' WHERE id =".$submission['id'];
        $result3 = mysqli_query($conn, $sql);
    }
}
?>