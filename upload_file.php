<?php
include_once('Model/File.php');
include_once('Model/Config.php');

use Model\File;
use Model\Config;

if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {
    $name = $_FILES["file"]["name"];
    $path = $_FILES["file"]["tmp_name"];
    $destination = Config::$tmpPath . $name;
    move_uploaded_file($path, $destination);
    $path = $destination;
    $file = new File($name, $path);
    echo $file->readFile();
    $file->closeFile();
}
?>
