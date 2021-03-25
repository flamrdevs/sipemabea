<?php

namespace App\Helpers;

// Laravel
use Storage;

class Helper
{
    public static function getOriginalFileName($filename)
    {
        $sep = config('global.filename-separator');
        return substr(substr($filename, strpos($filename, $sep)), strlen($sep));
    }

    public static function getStaticJson()
    {
        return json_decode(Storage::disk('local')->get('site/static.json'), true);
    }
}