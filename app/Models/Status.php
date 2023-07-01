<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static Builder enabled()
 * @method static Builder model(string $class)
 * @method static Builder default()
 */
class Status extends Model
{
    use CrudTrait;
    use HasFactory;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'statuses';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $status) {
            self::resetToNotDefault($status);
        });

        static::updating(function (self $status) {
            self::resetToNotDefault($status);
        });

    }

    private static function resetToNotDefault(self $status)
    {
        if ($status->is_default == true) {
            self::model($status->model)->update(['is_default' => false]);
        }
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function parent()
    {
        return $this->belongsTo(Status::class, 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeEnabled(Builder $query)
    {
        return $query->where('enabled', true);
    }

    public function scopeDefault(Builder $query)
    {
        return $query->where('is_default', true);
    }

    public function scopeModel(Builder $query, string $model)
    {
        return $query->where('model', $model);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
