<?php

    function SEO($str) {
        // Lowercase and replace non alphanumerics with hyphens.
        $str = strtolower($str);
        $str = preg_replace("/[^A-Za-z0-9]/", '-', $str);

        // Remove duplicate hyphens.
        while(strpos($str, "--") !== false) {
            $str = str_replace("--", "-", $str);
        }

        // Remove leading hyphens.
        while(strlen($str) > 0 && substr($str, 0, 1) == "-") {
            $str = substr($str, 1);
        }

        // Remove trailng hyphens.
        while(strlen($str) > 0 && substr($str, strlen($str) - 1, 1) == "-")
            $str = substr($str, 0, strlen($str) - 1);

        // Return result.
        return $str;
    }

    function UnSEO($str) {
        return str_replace("-", " ", $str);
    }
