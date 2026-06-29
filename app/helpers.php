<?php

if (!function_exists("get_image_url")) {
    function get_image_url($image, $width = 800, $height = 400)
    {
        if (empty($image)) {
            return "https://picsum.photos/seed/" . rand(1, 100) . "/" . $width . "/" . $height;
        }
        
        // If it's already a full URL (starts with http)
        if (str_starts_with($image, "http://") || str_starts_with($image, "https://")) {
            return $image;
        }
        
        // Otherwise, it's a local storage path
        return asset("storage/" . $image);
    }
}
