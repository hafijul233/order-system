<?php

namespace App\Traits;

use App\Models\Status;
use App\Models\StatusHistory;
use Illuminate\Database\Eloquent\Collection;

trait HasStatus
{
    /**
     * Return all status collection that are enabled
     * @return Collection
     */
    public static function statuses(): Collection
    {
        return Status::enabled()->where('model', __CLASS__)->get();
    }

    public static function statusDropdown(): array
    {
        return self::statuses()->pluck('name', 'id')->toArray();
    }

    public function status()
    {
        return $this->morphOne(StatusHistory::class, 'statusable')
            ->join('statuses', 'status.id', '=', 'status_histories.status_id')
            ->orderBy('status_history.created_at', 'desc');
    }

    public function statusHistory()
    {
        return $this->morphMany(StatusHistory::class, 'statusable')
            ->with(['status']);
    }

    public function getStatusAttribute()
    {
        $status = $this->status()->w->first();

        if ($status) {
            return __($status->key);
        }

        return null;
    }

    public function setStatusAttribute()
    {

    }

    public function getStatusHistoryAttribute()
    {
        return $this->statusHistory()->get() ?? [];
    }
}
