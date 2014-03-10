<?php

namespace Model;


class Content extends SimpleCharacterStream
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

    function __toString()
    {
        return $this->_data;
    }

}