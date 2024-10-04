<?php

namespace App\Http\Controllers\Revolut;

abstract class AbstractRevolut
{
    public static function setHash(array $array): string
    {
        return hash_hmac('sha1', serialize($array), config('app.key'));
    }

    public static function humanFileSize(int $bytes, $decimals = 2): string
    {
        $size = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    public static function getFetchResult(string $ticker, int $result = 0): string
    {
        switch ($result) {
            case 0:
                $message = $ticker . ' - fetched';
                break;
            case 1:
                $message = $ticker . ' - already fetched';
                break;
            case 2:
                $message = $ticker . ' - NO data';
                break;
            default:
                $message = $ticker . ' - unknown error';
                break;
        }

        return $message;
    }
}
