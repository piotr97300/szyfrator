<?php

namespace Model;


class Content
{
    private $_data;
    private $_offset;

    public function getData()
    {
        return $this->_data;
    }


    function __construct($_data)
    {
        $this->_offset = 0;
        $this->_data = $_data;
    }

    function __toString()
    {
        return $this->_data;
    }


    public function getLength()
    {
        return strlen($this->_data);
    }

    public function rewind()
    {
        return $this->_offset = 0;
    }

    public function nextChar()
    {
        if ($this->_offset == $this->getLength()) {
            return false;
        } else {
            $char = $this->_data[$this->_offset];
            $this->_offset = $this->_offset + 1;
            return $char;

        }
    }

    public function append($str)
    {
        $this->_data = $this->_data . $str;
    }
}