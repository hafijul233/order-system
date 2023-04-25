<?php

namespace App\Models;

use App\Traits\HasStatus;
use App\Traits\NewsletterSyncTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property-read string type_html
 */
class Customer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CrudTrait;
    use HasFactory;
    use Notifiable;
    use HasStatus;
    use NewsletterSyncTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public const TYPES = [
        'offline' => 'Offline',
        'online' => 'Online'
    ];


    protected $table = 'customers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    protected $dates = [
        'email_verified_at',
        'phone_verified_at'
    ];

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
/*        static::creating(function (self $customer) {
            dd($customer);
        });*/
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function addresses(): MorphMany
    {
        return $this->morphMany(AddressBook::class, 'addressable');
    }
    public function newsletter(): MorphOne
    {
        return $this->morphOne(Newsletter::class, 'newsletterable');
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
            'online' => "<span class='text-success'><i class='la la-globe-asia'></i> " . self::TYPES[$this->type] . "</span>",
            'offline' => "<span class='text-black-50'><i class='la la-building'></i> " . self::TYPES[$this->type] . "</span>",
            default => "<span class='text-warning'><i class='la la-warning'></i>N/A</span>"
        };
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }
}
