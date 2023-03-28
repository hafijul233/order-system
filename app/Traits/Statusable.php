<?php

namespace App\Traits;

use App\Models\StatusHistory;

trait Statusable
{
    public function status()
    {
        return $this->morphOne(StatusHistory::class, 'model')
            ->join('statuses', 'status.id', '=', 'status_histories.status_id')
            ->orderBy('status_history.created_at', 'desc');
    }

    public function statusHistory()
    {
        return $this->morphMany(StatusHistory::class, 'model')
            ->with(['status'])
            ->orderBy('created_at', 'desc');
    }

    public function getStatusAttribute()
    {
        $status = $this->status()->w->first();

        if ($status) {
            return __($status->key);
        }

        return null;
    }

    public function getStatusLevelAttribute()
    {
        $status = $this->status()->first();

        if ($status) {
            return $status->level;
        }

        return null;
    }

    public function getShortStatusAttribute()
    {
        $status = $this->status()->first();

        if ($status) {
            return __($status->short_key);
        }

        return null;
    }

    public function getStatusHistoryAttribute()
    {
        return $this->statusHistory()->get() ?? [];
    }
}
