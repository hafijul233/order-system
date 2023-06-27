<?php

namespace App\Models;

use App\Traits\EmailPhoneVerifyTrait;
use App\Traits\HasStatus;
use App\Traits\NewsletterSyncTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\HasUploadFields;
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
    use HasUploadFields;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    
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

    public static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            if (count((array)$model->attachments)) {
                foreach ($model->attachments as $file_path) {
                    \Storage::disk('public')->delete($file_path);
                }
            }
        });

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

    public function setLogoAttribute($value)
    {
        $attribute_name = "attachments";
        $disk = "public";
        $destination_path = "media/companies/" . date("Y/F/d");

        if(!file_exists(public_path($destination_path))) {
            mkdir(public_path($destination_path), 0777, true);
        }
        
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
