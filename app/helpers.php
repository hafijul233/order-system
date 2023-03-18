<?php

if (!function_exists('setting')) {
    /**
     * convenient setting helper to get setting data
     *
     * @param string $key
     * @param $value
     * @return bool|string
     */
    function setting(string $key, $value = null): bool|string
    {
        if ($value == null) {
            return \Backpack\Settings\app\Models\Setting::get($key);
        }

        return \Backpack\Settings\app\Models\Setting::set($key, $value);
    }
}
