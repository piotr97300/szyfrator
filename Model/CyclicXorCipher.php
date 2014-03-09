<?php

namespace Model;

class CyclicXorCipher implements Cipher
{
    private static function apply(Content $content, CyclicKey $key)
    {
        $resultContent = new Content("");
        $nextChar = $content->nextChar();
        while (is_string($nextChar)) {
            $resultContent->append(chr(ord($nextChar) ^ ord($key->nextChar())));
            $nextChar = $content->nextChar();
        }
        return $resultContent;
    }

    public static function decrypt(Content $content, Key $key)
    {
        return CyclicXorCipher::apply($content, $key);
    }

    public static function encrypt(Content $content, Key $key)
    {
        return CyclicXorCipher::apply($content, $key);
    }
}