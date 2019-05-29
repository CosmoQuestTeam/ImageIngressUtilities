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
echo "Connected successfully\n";

// --------------------------------
$imageset_id = 4211;
$image_name = "20190321T180657S512_pol_iofL2pan.png";
// --------------------------------


// Output a header

echo "id\t image_name\t x\t y\t diameter\t type\t details\t date\t user_id\n";


// Find all images related to that image set and get their offsets

$sql = "SELECT * FROM images WHERE image_set_id = ".$imageset_id;
$result = mysqli_query($conn, $sql);


while($image = mysqli_fetch_assoc($result)) {

    $coord = json_decode($image['details'], true);
    echo $coord['x']." ".$coord['y']."\n";

    // Get all members of the marks and output data

    $sql = "SELECT * FROM marks WHERE image_id = ".$image['id'];
    $result2 = mysqli_query($conn, $sql);
    while($mark = mysqli_fetch_assoc($result2)) {
        $x = $mark['x'] + $coord['x'];
        $y = $mark['y'] + $coord['y'];

        if(!strncmp($mark['details'],"{\"points",5)) {
            $boulder = json_decode($mark['details'],true);
            $details  = '{"points":[{"x":';
            $details .= $boulder['points'][0]['x'];
            $details .= ',"y":';
            $details .= $boulder['points'][0]['y'];
            $details .= '},{"x":';
            $details .= $boulder['points'][1]['x'];
            $details .= ',"y":';
            $details .= $boulder['points'][1]['y'];
            $details .= '}]}';
        }
        else {
            $details = '[]';
        }

        echo $mark['id'] ."\t". $image_name ."\t". $x ."\t". $y ."\t". $mark['diameter'] ."\t". $mark['type'] ."\t". $details ."\t". $mark['created_at'] ."\tuser_id". $mark['user_id']  ."\n";
    }
}
?>