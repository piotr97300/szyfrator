<?php

namespace Model;


interface Cipher
{
    /**
     * @param Content $content what to decrypt
     * @param Key $key used key
     * @return content decrypted Content
     */
    public static function decrypt(Content $content, Key $key);

    /**
     * @param Content $content what to encrypt
     * @param Key $key used key
     * @return content encrypted Content
     */
    public static function encrypt(Content $content, Key $key);

} 