<?php

namespace App\Models;

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

    public const PLATFORMS = [
        'android' => 'Android App',
        'ios' => 'iOS App',
        'website' => 'Web Site',
        'office' => 'System',
        'store' => 'Store',
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
    protected static function booted(): void
    {
        static::saving(function (self $model) {
            $model->syncVerifiedDate();
        });
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
        return match ($this->type) {
            'android' => "<span class='text-success'><i class='la la-android'></i> " . self::PLATFORMS[$this->platform] . "</span>",
            'ios' => "<span class='text-success'><i class='la la-app-store-ios'></i> " . self::PLATFORMS[$this->platform] . "</span>",
            'website' => "<span class='text-success'><i class='la la-globe-asia'></i> " . self::PLATFORMS[$this->platform] . "</span>",
            'office' => "<span class='text-success'><i class='la la-building'></i> " . self::PLATFORMS[$this->platform] . "</span>",
            'store' => "<span class='text-success'><i class='la la-store'></i> " . self::PLATFORMS[$this->platform] . "</span>",
            default => "<span class='text-warning'><i class='la la-warning'></i>N/A</span>"
        };
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
