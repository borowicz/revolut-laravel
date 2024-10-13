<?php

namespace App\Http\Controllers\Revolut;

use App\Http\Controllers\Controller;

abstract class AbstractRevolutController extends Controller
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

    public static function getLastWorkDay(string $date = '')
    {
        $today = date('N'); // current day of the week as a number (1 for Monday, 7 for Sunday)
        if ($date) {
            // find
        }

        if ($today == 1) {
            $lastWorkDay = strtotime('last Friday');
        } elseif ($today == 7 || $today == 6) {
            $lastWorkDay = strtotime('last Friday');
        } else {
            $lastWorkDay = strtotime('yesterday');
        }

        $lastWorkDay = date('Y-m-d', $lastWorkDay);

        return $lastWorkDay;
    }
}
