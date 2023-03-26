<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Tags\HasSlug;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use CrudTrait;
    use HasFactory;
    use HasTranslations;

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
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $product) {
            if ($product->slug == null) {
                $product->slug = Str::slug($product->name);
                $product->getDirty();
            }
        });

        static::updating(function (self $product) {
            if ($product->slug == null) {
                $product->slug = Str::slug($product->name);
                $product->getDirty();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function category()
    {
        return $this->belongsTo(Category::class);
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
