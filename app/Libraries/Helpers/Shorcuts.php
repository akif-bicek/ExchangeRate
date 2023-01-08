<?php
if (!function_exists('environment'))
{
    function environment(): string
    {
        return strtolower(env('APP_ENVIRONMENT', 'dev'));
    }
}
