<?php
include_once('Model/File.php');
include_once('Model/CharacterStream.php');
include_once('Model/SimpleCharacterStream.php');
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

function prepareFilename($file)
{
    $encrypting = isset($_POST['encrypt']);
    $ext = Config::$extension;
    if ($encrypting) {
        $name = $file->getFilename() . $ext;
    } else {
        $name = preg_replace("/$ext/", "", $file->getFilename());
    }
    $name = preg_replace("/\s/", "_", $name);
    return $name;
}

function addHeaders($name, $processed)
{
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $name);
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($processed));
    ob_clean();
    flush();
}


function prepareFile()
{
    $name = $_FILES["file"]["name"];
    $path = $_FILES["file"]["tmp_name"];
    $destination = Config::$tmpPath . $name;
    move_uploaded_file($path, $destination);
    $path = $destination;
    $file = new File($name, $path);
    return $file;
}

function processFile($content)
{
    $key = new CyclicKey($_POST['key']);
    $encrypting = isset($_POST['encrypt']);
    $processed = $encrypting ? CyclicXorCipher::encrypt($content, $key) : CyclicXorCipher::decrypt($content, $key);
    return $processed;
}

if ($_FILES["file"]["error"] > 0) {
    $errorExplanations = array(
        0 => "There is no error, the file uploaded with success",
        1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
        2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
        3 => "The uploaded file was only partially uploaded",
        4 => "No file was uploaded",
        6 => "Missing a temporary folder"
    );
    echo "Error: " . $errorExplanations[$_FILES["file"]["error"]] . "<br>";
} else {
    try {
        $file = prepareFile();
        $content = $file->readFile();
        $processed = processFile($content);
        $name = prepareFilename($file);
        addHeaders($name, $processed);
        echo $processed;
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        $file->closeFile();
    }
}
?>
