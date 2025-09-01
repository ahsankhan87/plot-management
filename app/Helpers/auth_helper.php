<?php

use App\Libraries\Auth;


if (!function_exists('auth')) {
    function auth()
    {
        return Auth::getInstance();
    }
}
