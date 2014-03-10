<?php
namespace Model;

interface CharacterStream
{
    public function rewind();

    public function nextChar();

    public function getLength();

    public function append($str);
}