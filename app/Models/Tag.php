<?php

namespace App\Models;

use ArrayAccess;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as DbCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Tags\HasSlug;
use Spatie\Translatable\HasTranslations;

class Tag extends Model implements Sortable, Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CrudTrait;
    use HasFactory;
    use SortableTrait;
    use HasTranslations;
    use HasSlug;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tags';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    public $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    public array $translatable = ['name'];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function getLocale()
    {
        return app()->getLocale();
    }

    public function scopeWithType(Builder $query, string $type = null): Builder
    {
        if (is_null($type)) {
            return $query;
        }

        return $query->where('type', $type)->ordered();
    }

    public function scopeContaining(Builder $query, string $name, $locale = null): Builder
    {
        $locale = $locale ?? static::getLocale();

        return $query->whereRaw('lower(' . $this->getQuery()->getGrammar()->wrap('name->' . $locale) . ') like ?', ['%' . mb_strtolower($name) . '%']);
    }

    public static function findOrCreate(
        string | array | ArrayAccess $values,
        string | null $type = null,
        string | null $locale = null,
    ): Collection |self| static {
        $tags = collect($values)->map(function ($value) use ($type, $locale) {
            if ($value instanceof self) {
                return $value;
            }

            return static::findOrCreateFromString($value, $type, $locale);
        });

        return is_string($values) ? $tags->first() : $tags;
    }

    public static function getWithType(string $type): DbCollection
    {
        return static::withType($type)->get();
    }

    public static function findFromString(string $name, string $type = null, string $locale = null)
    {
        $locale = $locale ?? static::getLocale();

        return static::query()
            ->where('type', $type)
            ->where(function($query) use ($name, $locale) {
                $query->where("name->{$locale}", $name)
                    ->orWhere("slug->{$locale}", $name);
            })
            ->first();
    }

    public static function findFromStringOfAnyType(string $name, string $locale = null)
    {
        $locale = $locale ?? static::getLocale();

        return static::query()
            ->where("name->{$locale}", $name)
            ->orWhere("slug->{$locale}", $name)
            ->get();
    }

    protected static function findOrCreateFromString(string $name, string $type = null, string $locale = null)
    {
        $locale = $locale ?? static::getLocale();

        $tag = static::findFromString($name, $type, $locale);

        if (! $tag) {
            $tag = static::create([
                'name' => [$locale => $name],
                'type' => $type,
            ]);
        }

        return $tag;
    }

    public static function getTypes(): Collection
    {
        return static::groupBy('type')->pluck('type');
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->translatable) && ! is_array($value)) {
            return $this->setTranslation($key, static::getLocale(), $value);
        }

        return parent::setAttribute($key, $value);
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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
