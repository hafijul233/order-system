<?php

namespace App\Traits;

use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        }
        $this->status_id = $status->id;
        return $this->save();
    }

    /**
     * Return all status collection that are
     * enabled for current model
     *
     * @return Collection
     */
    private static function statuses()
    {
        return Status::enabled()->model(__CLASS__)->toSql();
    }

    /**
     * Return all status name id array that are
     * enabled for current model
     *
     * @return array
     */
    public static function statusDropdown(): array
    {
        dd(self::statuses());

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
     * @return BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
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
        return ($this->status instanceof Status)
            ? "<span style='color: {$this->status->color};'><i class='{$this->status->icon}'></i> {$this->status->name}</span>"
            : "<span class='text-secondary'><i class='la la-question'></i>N/A</span>";
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
