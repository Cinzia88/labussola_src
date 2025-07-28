<?php
if (! function_exists('cleanSpecialChars')) {

    function cleanSpecialChars($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
     
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }
}

if (!function_exists('generateDownloadUrlFile')) {
    /*
     * Generate download url for file from Spatie Media Library Path (local disk)
    */
    function generateDownloadUrlFile(string $path): string
    {
        $path = str_replace('/', '\\', $path);
        $sliced_path = array_slice(explode("\\", $path), -2, 2);
        return $sliced_path[1];
    }
}  

if (!function_exists('generateDownloadUrlFolder')) {
    /*
     * Generate download url for folder from Spatie Media Library Path (local disk)
    */
    function generateDownloadUrlFolder(string $path): string
    {
        $path = str_replace('/', '\\', $path);
        $sliced_path = array_slice(explode("\\", $path), -2, 2);
        return $sliced_path[0];
    }
}  