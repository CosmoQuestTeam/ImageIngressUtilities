<?php
/**
 * Created by PhpStorm.
 * User: starstryder
 * Date: 5/15/19
 * Time: 2:43 PM
 */

// Step 0: Read settings file
require_once("WriteInsertQueries_settings.php");

// Step 1: Open files
$imagesets = fopen($file_imagesets, 'r') or die("Cannot open " . $file_imagesets);
$output    = fopen($file_queries, 'w') or die("Cannot open " . $$file_queries);

$set_id=4200;
while (!feof($imagesets)) {

    $image = fgets($imagesets);
    $extension = substr($image, -5, -1);
    $image = substr($image, 0, -5);

    // Create the Image Set Insert - RUN THIS ALONE FOR NOW, THEN COMMENT OUT
    //$query = "INSERT INTO image_sets (name, application_id) VALUES ('".$image.$extension."', 21);\r\n ";
    //fwrite($output, $query);

// Step 2: Get offsets
//      Step 2a: enter offset amount


    if (!strcmp($offset_type, "offset")) {
        echo "Regular offsets in use. \n";
    }
// OR
//      Step 2b: enter manual offsets

    elseif (!strcmp($offset_type, "manual")) {
        echo "manual offsets in use. \n";

        $x_arraysize = sizeof($x_array);
        $y_arraysize = sizeof($y_array);

        $cnt = 0;

        for ($i = 0; $i < $x_arraysize; $i++) {
            for ($j = 0; $j < $y_arraysize; $j++) {
                $x = $x_array[$i];
                $y = $y_array[$j];
                $cnt++;
                $query = "INSERT INTO images (image_set_id, application_id, name, file_location, premarked, done, details) ";
                $query .= "VALUES (".$set_id.", 21, '".$image."_".$cnt."', '".$path_choppedImages.$image."_".$cnt.$extension."', 0, 0, '{\"x\":$x, \"y\":$y}');\r\n";
                fwrite($output, $query);
            }
        }
    } else {
        die("Valid offset type not given.");
    }
    $set_id++;

}

// Step 4: generate queries
//      Step 4a: Generate image sets
// AND
//      Step 4b: Generate images


?>
