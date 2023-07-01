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

if (!function_exists('is_installed')) {
    /**
     * return current application installation status
     * 
     * @return bool
     */
    function is_installed()
    {
        return file_exists(storage_path('installed'));
    }
}
