<?php

namespace App\Models;

use App\Traits\HasStatus;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property-read string $type_html
 * @property-read string $addressable_html
 */
class AddressBook extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CrudTrait;
    use HasFactory;
    use HasStatus;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public const TYPES = [
        'home' => 'Home',
        'ship' => 'Delivery',
        'bill' => 'Billing',
        'work' => 'Work',
        'other' => 'Other',
    ];

    protected $table = 'address_books';
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


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
    public function customers(): MorphToMany
    {
        return $this->morphedByMany(Customer::class, 'addressable');
    }
    public function companies()
    {
        return $this->morphedByMany(Company::class, 'addressable');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
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
    public function getTypeHtmlAttribute(): string
    {
        return match ($this->type) {
            'home' => "<span class='text-info'><i class='la la-home'></i> " . self::TYPES[$this->type] . "</span>",
            'ship' => "<span class='text-info'><i class='la la-shipping-fast'></i> " . self::TYPES[$this->type] . "</span>",
            'bill' => "<span class='text-info'><i class='la la-file-invoice-dollar'></i> " . self::TYPES[$this->type] . "</span>",
            'work' => "<span class='text-info'><i class='la la-user-graduate'></i> " . self::TYPES[$this->type] . "</span>",
            'other' => "<span class='text-info'><i class='la la-exclamation'></i> " . self::TYPES[$this->type] . "</span>",
            default => "<span class='text-warning'><i class='la la-warning'></i>N/A</span>"
        };
    }
    public function getAddressableHtmlAttribute(): string
    {
        if ($this->addressable instanceof Customer) {
            return "<a class='text-info text-decoration-none' style='font-weight: 550 !important;' title='Customer' target='_blank' href='" . route('customer.show', $this->addressable->id) . "'><i class='la la-user-check text-info'></i> {$this->addressable->name}</a>";
        } elseif ($this->addressable instanceof Company) {
            return "<a class='text-info text-decoration-none' style='font-weight: 550 !important;' title='Company' target='_blank' href='" . route('company.show', $this->addressable->id) . "'><i class='la la-building text-success'></i> {$this->addressable->name}</a>";
        } else {
            return '-';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
