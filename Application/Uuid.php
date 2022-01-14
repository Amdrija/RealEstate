<?php

namespace Amdrija\RealEstate\Application;

use Exception;

class Uuid
{
    public static function newUUID(): string
    {
        $length = 32;
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($length / 2));
        } else {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        }

        $uuid = bin2hex($bytes);
        return substr($uuid, 0, 8) . "-" .
            substr($uuid, 8, 4) . "-" .
            substr($uuid, 12, 4) . "-" .
            substr($uuid, 16, 4) . "-" .
            substr($uuid, 20, 12);

    }
}