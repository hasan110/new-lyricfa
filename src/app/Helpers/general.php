<?php

if (!function_exists('set4digit')) {
    function set4digit(string $str): string
    {
        return match (strlen($str)) {
            1 => '000' . $str,
            2 => '00' . $str,
            3 => '0' . $str,
            4 => $str,
            default => '0000',
        };
    }
}

if (!function_exists('homogenization')) {
    /**
     * remove unacceptable characters from string
     * @param string $text
     * @return string|int|null
     */
    function homogenization(string $text): string|int|null
    {
        $text = trim($text);
        if (strlen($text) == 0) return '';
        $text = str_replace("ي", "ی", $text);
        $text = str_replace("ك", "ک", $text);
        $text = str_replace('`', " ", $text);
        // Arabic Number
        $text = str_replace("٠", "0", $text);
        $text = str_replace("١", "1", $text);
        $text = str_replace("٢", "2", $text);
        $text = str_replace("٣", "3", $text);
        $text = str_replace("٤", "4", $text);
        $text = str_replace("٥", "5", $text);
        $text = str_replace("٦", "6", $text);
        $text = str_replace("٧", "7", $text);
        $text = str_replace("٨", "8", $text);
        $text = str_replace("٩", "9", $text);
        // Persian Number
        $text = str_replace("۰", "0", $text);
        $text = str_replace("۱", "1", $text);
        $text = str_replace("۲", "2", $text);
        $text = str_replace("۳", "3", $text);
        $text = str_replace("۴", "4", $text);
        $text = str_replace("۵", "5", $text);
        $text = str_replace("۶", "6", $text);
        $text = str_replace("۷", "7", $text);
        $text = str_replace("۸", "8", $text);
        return str_replace("۹", "9", $text);
    }
}
