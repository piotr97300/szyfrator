<?php
include_once('Model/File.php');
include_once('Model/Config.php');
include_once('Model/Content.php');
include_once('Model/Cipher.php');
include_once('Model/Key.php');
include_once('Model/CyclicKey.php');
include_once('Model/CyclicXorCipher.php');

use Model\CyclicKey;
use Model\CyclicXorCipher;
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

    $key = new CyclicKey($_POST['key']);

    $encrypting = isset($_POST['encrypt']);
    $processed = $encrypting ? CyclicXorCipher::encrypt($content, $key) : CyclicXorCipher::decrypt($content, $key);

    $ext = Config::$extension;
    if($encrypting){
        $name = $file->getFilename().$ext;
    } else {
        $name = preg_replace("/$ext/","",$file->getFilename());
    }
    $name = preg_replace("/\s/","_",$name);


    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.$name);
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($processed));
    ob_clean();
    flush();
    echo $processed;

}
?>
