<?php

namespace Model;


class Content extends SimpleCharacterStream //extends-dziedziczenie
{

    public function getData()
    {
        return $this->_data;
    }


    function __construct($_data)
    {
        $this->_offset = 0;
        $this->_data = $_data;
    }

    function getDataString() //po  co????
    {
        return (string)$this->_data;
    }

    public function append($str)//dodaje znak na koniec pliku
    {
        $this->_data = $this->_data . $str; //kropka laczy stringi
    }

}