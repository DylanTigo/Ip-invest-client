<?php

use Carbon\Carbon;

if (!function_exists('dateFormat')) {
    function dateFormat($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}

if (!function_exists('timeFormat')) {
    function timeFormat($date)
    {
        return \Carbon\Carbon::parse($date)->format('H\hi\m\i\n');
    }
}

function extractFirstImage($html)
{
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $images = $dom->getElementsByTagName('img');
    if ($images->length > 0) {
        return $images->item(0)->getAttribute('src');
    }
    return null;
}
