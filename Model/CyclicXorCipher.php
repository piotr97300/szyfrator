<?php

namespace Model;

class CyclicXorCipher implements Cipher
{ //apply - XORowanie
    private static function apply(Content $content, CyclicKey $key)
    {
        $resultContent = new Content(""); //
        $nextChar = $content->nextChar();
        while (is_string($nextChar)) {
            $resultContent->append(chr(ord($nextChar) ^ ord($key->nextChar())));//ord-znaki na liczby ,chr-liczby na znaki
            $nextChar = $content->nextChar();
        }
        //append-dodawanie znaku na koniec pliku
        return $resultContent;
    }

    public static function decrypt(Content $content, CyclicKey $key)
    {
        return CyclicXorCipher::apply($content, $key);
    }

    public static function encrypt(Content $content, CyclicKey $key)
    {
        return CyclicXorCipher::apply($content, $key);
    }
}