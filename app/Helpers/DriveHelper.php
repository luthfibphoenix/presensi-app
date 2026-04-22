<?php

if (!function_exists('convertGoogleDriveUrl')) {
    function convertGoogleDriveUrl($url)
    {
        if (empty($url)) {
            return null;
        }

        // Regex untuk mencari ID file Google Drive dari berbagai format URL
        $pattern = '/[-\w]{25,}/';
        
        if (preg_match($pattern, $url, $match)) {
            $fileId = $match[0];
            return "https://drive.google.com/uc?export=view&id={$fileId}";
        }

        return $url;
    }
}

if (!function_exists('jamPelajaranToWaktu')) {
    function jamPelajaranToWaktu($jamKe)
    {
        return \App\Models\Jadwal::getWaktu($jamKe);
    }
}
