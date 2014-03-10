<?php
namespace Model;

abstract class SimpleCharacterStream implements CharacterStream
{
    protected  $_data;
    protected  $_offset;


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