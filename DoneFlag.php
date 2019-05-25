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

// Make sure nothing is marked done that shouldn't be
// ONLY USE IMAGE SETS WITH image_set_it > 4200. These are images with id >=  41228380

$sql = "SELECT id FROM images WHERE id >= 41228380 AND image_set_id != 4256";
$result = mysqli_query($conn, $sql);
while($image = mysqli_fetch_assoc($result)) {

    // Check if the image has been done 15 or more times after excluding blanks and duplicates
    $sql = "SELECT id FROM image_users WHERE image_id = ".$image['id']." AND details IS NULL";
    $result2 = mysqli_query($conn, $sql);

    if ( mysqli_num_rows($result2) >= 15 ) {
        $sql = "UPDATE image SET done = 1 WHERE id =".$image['id'];
        $result3 = mysqli_query($conn, $sql);
        echo "done ";
    }
    else {
        $sql = "UPDATE image SET done = 0 WHERE id =".$image['id'];
        $result3 = mysqli_query($conn, $sql);
        echo "todo ";
    }
}

?>