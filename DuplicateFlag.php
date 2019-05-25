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

// Get all the duplicates
$sql = "SELECT count(*) as N, id, image_id, user_id FROM image_users GROUP BY image_id, user_id";
$result = mysqli_query($conn, $sql);

while($images = mysqli_fetch_assoc($result)) {

    // if count > 1, let's fix shit
    if ($images['N'] > 1) {

        // Get all instances after the first instance of a duplicate
        // First Instance has id $images['id']
        $sql2 = "SELECT id FROM image_users WHERE id > ".$images['id']." AND user_id = ".$images['user_id']." AND image_id = ".$images['image_id'];
        $result2 = mysqli_query($conn, $sql2);

        // Mark each duplicate in the image_users and marks tables
        while($dup = mysqli_fetch_assoc($result2)) {
            echo $dup['id'].", ";
            $sql3 = "UPDATE image_users SET details = 'duplicate submission' WHERE id = ".$dup['id'];
            $result3 = mysqli_query($conn, $sql3);
            echo "Affected rows (Update): %d\n", mysqli_affected_rows($conn);
            
            $sql3 = "UPDATE marks SET sub_type='duplicate' WHERE image_user_id = ".$dup['id'];
            $result3 = mysqli_query($conn, $sql3);
            echo "Affected rows (Update): %d\n", mysqli_affected_rows($conn);

        }
        echo "\n";
    }
}
?>