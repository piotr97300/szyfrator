<?php

namespace Model;

class File
{
    private $_filename;
    private $_path;

    function __construct($path, $filename)
    {
        $this->_path = $path;
        $this->_filename = $filename;
    }

    public function getFilename()
    {
        return $this->_filename;
    }

    public function readFile()
    {
        if (file_exists($this->_path)) { //sprawdza czy sciezka istnieje
            $handle = fopen($this->_path, 'r'); //otwarcie pliku, tylko do odczytu,wskaznik na poczatku pliku
            $content = fread($handle, filesize($this->_path)); //odczytanie pliku,od poczatku do konca
            fclose($handle);//zamyka otwarty wskaznik pliku
            return new Content($content); //tworzy obiekt klasy Content z argumentem content,czyli zawartosc wczytanego pliku
        } else {
            return "404 - file '$this->_path' not found";
        }
    }

    public function closeFile()
    {
        unlink($this->_path); //kasowanie pliku
    }
} 