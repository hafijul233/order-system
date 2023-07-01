<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 *
 */
trait Sluggable
{
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if ($model->slug == null) {
                $model->slug = Str::slug($model->name);
                $model->getDirty();
            }
        });

        static::updating(function (self $model) {
            if ($model->slug == null) {
                $model->slug = Str::slug($model->name);
                $model->getDirty();
            }
        });
    }
}
