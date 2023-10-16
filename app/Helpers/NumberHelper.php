<?php

if (!function_exists('format_decimal')) {
    function format_decimal($number, $decimals = 2)
    {
        return number_format((float)$number, $decimals, ',', '.');
    }
}
