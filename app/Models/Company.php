<?php

namespace App\Models;

use App\Traits\EmailPhoneVerifyTrait;
use App\Traits\HasStatus;
use App\Traits\NewsletterSyncTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property-read Customer $representative
 */
class Company extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CrudTrait;
    use HasFactory;
    use HasStatus;
    use EmailPhoneVerifyTrait;
    use NewsletterSyncTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public const STATUSES = [
        'active' => 'Active',
        'suspended' => 'Suspended',
        'banned' => 'Banned'
    ];

    protected $table = 'companies';
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
    public function representative()
    {
        return $this->belongsTo(Customer::class, 'representative_id');
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
