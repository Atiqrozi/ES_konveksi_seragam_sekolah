<?php

if(!function_exists('IDR')) {
    function IDR ($value) {
        return 'Rp. ' . number_format($value, 0, '.', '.');
    }
}