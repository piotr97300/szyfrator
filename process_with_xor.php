<?php //kod wykonywany po wyslaniu formularza
include_once('Model/File.php');
include_once('Model/CharacterStream.php');
include_once('Model/SimpleCharacterStream.php');
include_once('Model/Config.php');
include_once('Model/Content.php');
include_once('Model/Cipher.php');
include_once('Model/CyclicKey.php');
//include_once('Model/CyclicKey.php');
include_once('Model/CyclicXorCipher.php');

//use=include w c
use Model\CyclicKey;
use Model\CyclicXorCipher;
use Model\File;
use Model\Config;

function prepareFilename($file)
{
    $encrypting = isset($_POST['encrypt']); //isset - sprawdza czy zmienna jest ustawiona(czy cos sie w niej znajduje)
    $ext = Config::$extension; // :: - uruchamianie metody klasy bez tworzenia obiektu
    if ($encrypting) {
        $name = $file->getFilename() . $ext; //tworzymy obiekt file i wywolujemy metode getFilename
    } else {
        $name = preg_replace("/$ext/", "", $file->getFilename());// kasuje rozszerzenie, wyszukuje $ext w filename,by zastapic "",czyli pustym polem
    }
    $name = preg_replace("/\s/", "_", $name); //spacje zamienia na podkreslenie
    return $name;
}
//wyswietla okienko pobierania
function addHeaders($name, $processed)
{
    header('Content-Description: File Transfer'); //header-wysyla surowy naglowek http
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $name);
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($processed));
    ob_clean(); //clean the output buffer
    flush(); //oproznia bufory wyjsciowe PHP
}


function prepareFile()
{//tablica FILES zawiera dane pliku wyslanego przez formularz HTML
    $name = $_FILES["file"]["name"]; //oryginalna nazwa wyslanego pliku
    $path = $_FILES["file"]["tmp_name"]; //sciezka do pliku na serwerze, tymczasowa nazwa pliku,ktory zostal wyslany na serwer,uzyta zostanie do skopiowania do folderu docelowego
    $destination = Config::$tmpPath . $name; //plik na serwerze w bierzacym katalogu
    move_uploaded_file($path, $destination); //przenosi zuploadowane pliki do nowej lokacji
    return new File($destination, $name);
}

function processFile($content)
{ //$_POST uzywamy w formularzach
    $key = new CyclicKey($_POST['key']);
    $encrypting = isset($_POST['encrypt']);
    $processed = $encrypting ? CyclicXorCipher::encrypt($content, $key) : CyclicXorCipher::decrypt($content, $key);
    return $processed;
}
//wyjatki dla wysylanego pliku-przepisane z dokumentacji PHP
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
    try { //w bloku try powinien znalezc sie kod, ktory ewentualnie moze wyrzucic jakis wyjatek
        $preparedFile = prepareFile();
        $content = $preparedFile->readFile();//odczytanie zawartosci pliku
        $processed = processFile($content); //szyfrowanie
        $name = prepareFilename($preparedFile); //dodawanie lub usuwanie rozszerzenia szyfrowania
        addHeaders($name, $processed->getDataString());
        echo $processed->getDataString();
    } catch (Exception $e) { //zlapie dowolny wyjatek, po bloku try musi nastapic przynajmniej jeden blok catch
        echo $e->getMessage();
    } finally {
        $preparedFile->closeFile();
    }
}
?>
