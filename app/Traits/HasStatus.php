<?php

namespace App\Traits;

use App\Models\Status;
use App\Models\StatusHistory;
use Illuminate\Database\Eloquent\Collection;

trait HasStatus
{

    public function addDefaultStatus(): void
    {
        if ($defaultStatus = \App\Models\Status::enabled()->model(__CLASS__)->default()->first()) {
            $this->statusHistory()->save(new StatusHistory(['status_id' => $defaultStatus->id]));
        }
    }

    /**
     * Return all status collection that are
     * enabled for current model
     *
     * @param string|null $class
     * @return Collection
     */
    public static function statuses(string $class = null): Collection
    {
        $class = $class ?? __CLASS__;

        return Status::enabled()->where('model', $class)->get();
    }

    /**
     * Return all status name id array that are
     * enabled for current model
     *
     * @param string|null $class
     * @return array
     */
    public static function statusDropdown(string $class = null): array
    {
        return self::statuses($class)->pluck('name', 'id')->toArray();
    }

    public function status()
    {
        return $this->morphOne(StatusHistory::class, 'model')
            ->join('statuses', 'statuses.id', '=', 'status_histories.status_id')
            ->orderBy('status_histories.created_at', 'desc');
    }

    public function statusHistory()
    {
        return $this->morphMany(StatusHistory::class, 'model')
            ->with(['status'])
            ->orderBy('created_at');
    }
}
