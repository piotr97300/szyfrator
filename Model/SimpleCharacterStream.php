<?php
namespace Model;

abstract class SimpleCharacterStream implements CharacterStream //implements-implementacja interfejsu
{
    protected  $_data;
    protected  $_offset;


    public function getLength()
    {
        return strlen($this->_data);
    }

    public function rewind() //przewijac, powrot na poczatek
    {
        return $this->_offset = 0;
    }

    public function nextChar()
    {
        if ($this->_offset == $this->getLength()) {
            return false;
        } else {
            $char = $this->_data[$this->_offset]; //kolejny znak z danych
            $this->_offset = $this->_offset + 1;
            return $char;

        }
    }
}