<?php
// app/HelperFunctions.php

if (!function_exists('cosineSimilarity')) {
    function cosineSimilarity($str1, $str2) {
        $vec1 = array_count_values(preg_split('/\s+/', strtolower($str1), -1, PREG_SPLIT_NO_EMPTY));
        $vec2 = array_count_values(preg_split('/\s+/', strtolower($str2), -1, PREG_SPLIT_NO_EMPTY));
        // dd($vec1);
        $intersection = array_intersect_key($vec1, $vec2);
        // dd($intersection);
        $dotProduct = 0;
        foreach ($intersection as $word => $count) {
            $dotProduct += $vec1[$word] * $vec2[$word];
        }

        $magnitude1 = sqrt(array_sum(array_map(function ($x) {
            return $x * $x;
        }, $vec1)));
        $magnitude2 = sqrt(array_sum(array_map(function ($x) {
            return $x * $x;
        }, $vec2)));
        // dd($magnitude2);
        if ($magnitude1 * $magnitude2 !== 0) {
            return $dotProduct / ($magnitude1 * $magnitude2);
        } else {
            return 0; // Default value if magnitude is zero to prevent division by zero
        }
    }

}

