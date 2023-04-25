<?php

namespace App\Traits;

use App\Models\Status;
use App\Models\StatusHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property-read string status_html
 */
trait HasStatus
{
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    /**
     * Add given or default status to model status history logs
     *
     * @param int|null $id
     * @return bool
     */
    public function addStatus(int $id = null): bool
    {
        $status = Status::enabled()
            ->model(__CLASS__)
            ->when($id == null, fn($query) => $query->default())
            ->when($id != null, fn($query) => $query->where('id', $id))
            ->first();

        if ($status == null) {
            throw new \InvalidArgumentException("Default or Invalid Status Model id passed for " . basename(__CLASS__) . " status value.");
        } else {
            return (bool)$this->statusHistory()->save(new StatusHistory(['status_id' => $status->id]));
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
        return Status::enabled()->model(__CLASS__)->get();
    }

    /**
     * Return all status name id array that are
     * enabled for current model
     *
     * @return array
     */
    public static function statusDropdown(): array
    {
        return self::statuses()->pluck('name', 'id')->toArray();
    }

    /**
     * Return current model last status in html string  form
     *
     * @return int|null
     */
    public static function defaultStatusId(): ?int
    {
        $status = Status::enabled()->default()->model(__CLASS__)->first();

        return ($status) ? $status->id : null;

    }

    /**
     * return current model status
     * @return array
     */
    public static function statusesId(): array
    {
        return self::statuses()->pluck('id')->toArray();
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * Return current model last status model instance
     * @return MorphOne
     */
    public function status(): MorphOne
    {
        return $this->morphOne(StatusHistory::class, 'model')
            ->join('statuses', 'statuses.id', '=', 'status_histories.status_id')
            ->orderBy('status_histories.created_at', 'desc');
    }

    /**
     * Return current model last status history collection  instance
     * @return MorphMany
     */
    public function statusHistory()
    {
        return $this->morphMany(StatusHistory::class, 'model')
            ->with(['status'])
            ->orderBy('created_at');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    /**
     * Return current model last status in html string  form
     *
     * @return string
     */
    public function getStatusHtmlAttribute(): string
    {
        return ($this->status()->exists())
            ? "<span style='color: {$this->status->color};'><i class='{$this->status->icon}'></i> {$this->status->name}</span>"
            : "<span class='text-secondary'><i class='la la-question'></i>N/A</span>";
    }

    /**
     * @return mixed
     */
    public function getCustomStatusIdAttribute()
    {
        return $this->status->id ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
