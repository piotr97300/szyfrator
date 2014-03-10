<?php

namespace Model;


class CyclicKey extends SimpleCharacterStream implements Key
{
    function __construct($key)
    {
        $this->_offset = 0;
        if (is_string($key) && strlen($key) > 0) {
            $this->_data = $key;
        } else {
            throw new \UnexpectedValueException('Nonempty string key expected');
        }
    }

    public function nextChar()
    {
        $char = $this->_data{$this->_offset};
        $this->_offset += 1;
        if ($this->_offset == $this->getLength()) {
            $this->_offset = 0;
        }
        return $char;
    }
} 