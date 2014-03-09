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
        if (file_exists($this->_path)) {
            $handle = fopen($this->_path, 'r');
            $content = fread($handle, filesize($this->_path));
            fclose($handle);
            return $content;
        } else {
            return "404 - file '$this->_path' not found";
        }
    }

    public function closeFile()
    {
        unlink($this->_path);
    }
} 