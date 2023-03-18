<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use OwenIt\Auditing\Contracts\Auditable;

class AddressBook extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CrudTrait;
    use HasFactory;

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

    public const STATUSES = [
        'active' => 'Active',
        'suspended' => 'Suspended',
        'banned' => 'Banned'
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
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $addressBook) {
            [$addressable_type, $addressable_id] = explode(':', request('addressable'));
            $addressBook->addressable_id = $addressable_id;
            $addressBook->addressable_type = $addressable_type;
            $addressBook->getDirty();
        });

        static::updating(function (self $addressBook) {
            [$addressable_type, $addressable_id] = explode(':', request('addressable'));
            $addressBook->addressable_id = $addressable_id;
            $addressBook->addressable_type = $addressable_type;
            $addressBook->getDirty();
        });


    }
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
