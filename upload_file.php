<?php
include_once('Model/File.php');
include_once('Model/Config.php');
include_once('Model/Content.php');
include_once('Model/Cipher.php');
include_once('Model/Key.php');
include_once('Model/CyclicKey.php');
include_once('Model/CyclicXorCipher.php');

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
    $content = $file->readFile();
    echo $content;
    echo '<br>';
    echo '<br>';
    echo '<br>';
    $key = new \Model\CyclicKey("lol");
    $encrypted = \Model\CyclicXorCipher::encrypt($content, $key);
    echo $encrypted;
    $file->closeFile();
    echo '<br>';
    echo '<br>';
    echo '<br>';
    $key = new \Model\CyclicKey("lol");
    $encrypted = \Model\CyclicXorCipher::decrypt($encrypted, $key);
    echo $encrypted;
}
?>
