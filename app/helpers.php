<?php

if (!function_exists('setting')) {
    /**
     * convenient setting helper to get setting data
     *
     * @param string $key
     * @param $value
     * @return mixed
     */
    function setting(string $key, $value = null)
    {
        if ($value == null) {
            return \Backpack\Settings\app\Models\Setting::get($key);
        }

        return \Backpack\Settings\app\Models\Setting::set($key, $value);
    }
}
