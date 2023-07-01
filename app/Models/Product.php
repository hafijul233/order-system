<?php

namespace App\Models;

use App\Traits\HasStatus;
use App\Traits\Sluggable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property-read string $platform_html
 */
class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CrudTrait;
    use HasFactory;
    use HasTranslations;
    use Sluggable;
    use HasStatus;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public const PLATFORMS = [
        'online' => 'Online',
        'offline' => 'Offline',
        'both' => 'Both'
    ];

    public const TYPES = ['normal' => 'Normal', 'bundle' => 'Bundle/Combo'];

    protected $table = 'products';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    public array $translatable = ['name', 'short_description', 'description'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class);
    }

    public function defaultUnit()
    {
        return $this->belongsTo(Unit::class, 'default_unit_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
        ->withPivot('value', 'unit_id')
        ->withTimestamps();
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
    public function getPlatformHtmlAttribute()
    {
        return match ($this->platform) {
            'online' => "<span class='text-success'><i class='la la-globe-asia'></i> " . self::PLATFORMS[$this->platform] . "</span>",
            'offline' => "<span class='text-black-50'><i class='la la-building'></i> " . self::PLATFORMS[$this->platform] . "</span>",
            'both' => "<span class='text-black-50'><i class='la la-mail-bulk'></i> " . self::PLATFORMS[$this->platform] . "</span>",
            default => "<span class='text-warning'><i class='la la-warning'></i>N/A</span>"
        };
}
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
