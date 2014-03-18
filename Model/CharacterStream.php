<?php
namespace Model;
//interfejs jest ulatwieniem dla programisty
//tworzymy zbior metod,ktore mozemy implementowac w klasach
//jezeli implementujemy interfejs, musimy skorzystac z wszystkich metod!!!
//interfejsow nie dotycza ograniczenia dziedziczenia
//mozemy implementowac kilka interfejsow
//mozemy implementowac interfejsy w interfejsach
interface CharacterStream
{
    //prototypy metod
    //uzywamy tylko public,z zalozenia interfejsu
    public function rewind();

    public function nextChar();

    public function getLength();

}