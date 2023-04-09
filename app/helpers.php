<?php

if (!function_exists('setting')) {
    /**
     * convenient setting helper to get setting data
     *
     * @param string $key
     * @param null $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        return config("settings.{$key}", $default);
    }
}
