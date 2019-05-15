<?php
/**
 * Created by PhpStorm.
 * User: starstryder
 * Date: 5/15/19
 * Time: 2:51 PM
 */

// The location of the list of image sets
$file_imagesets = "/Users/starstryder/Desktop/TINYTEST/5imageMaster.txt";

// The location where the query file should go
$file_queries = "/Users/starstryder/Desktop/queries.sql";

// Path to images (likely on S3)
$path_choppedImages = "https://s3.amazonaws.com/cosmoquest/data/mappers/osiris/5imageMaster/CHOPPEDIMAGES/";

// Kind of offset. Allowed values: manual, offset
$offset_type = "manual";

// Get the size of each image in pixels
$x_size = 450;
$y_size = 450;

// IF MANUAL, enter the values for each access in the format (0, 100, 275);
$x_array = array(0, 225, 574);
$y_array = array(0, 225, 574);

// IF OFFSET, enter the number of pixels between edges of images (will overlap if x_offset < x_size)
$x_offset = 400;
$y_offset = 400;

