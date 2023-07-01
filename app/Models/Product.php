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
 * @property string $platform
 * @property string $name
 * @property string $status_html
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
        return $this->belongsToMany(Attribute::class, 'product_attribute')
        ->withPivot('value', 'unit_id')
        ->withTimestamps();
    }
    /**
     * return the parent model of this product
     */
    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    /**
     * return a collection to items included in bundle type product
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'parent_id');
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
            'wev' => "<span class='text-success'><i class='la la-globe-asia'></i> " . config("constant.product_visibility.{$this->platform}") . "</span>",
            'store' => "<span class='text-black-50'><i class='la la-building'></i> " . config("constant.product_visibility.{$this->platform}") . "</span>",
            'both' => "<span class='text-black-50'><i class='la la-mail-bulk'></i> " . config("constant.product_visibility.{$this->platform}") . "</span>",
            default => "<span class='text-warning'><i class='la la-warning'></i>N/A</span>"
        };
}
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
