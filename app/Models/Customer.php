<?php

namespace App\Models;

use App\Helpers\UtilityHelper;
use App\Traits\EmailPhoneVerifyTrait;
use App\Traits\HasStatus;
use App\Traits\NewsletterSyncTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property-read string platform_html
 */
class Customer extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CrudTrait;
    use HasFactory;
    use Notifiable;
    use HasStatus;
    use EmailPhoneVerifyTrait;
    use NewsletterSyncTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

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
    protected static function booted(): void
    {
        static::saving(function (self $model) {
            $model->syncVerifiedDate();
        });
    }

    public function idLabel() 
    {
        return $this->name;
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

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'representative_id');
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
    public function getPlatformHtmlAttribute(): string
    {
        return UtilityHelper::platformIcon($this->platform);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
