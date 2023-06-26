<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\HasUploadFields;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OrderNote extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CrudTrait;
    use HasUploadFields;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'order_notes';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'attachments' => 'array'
    ];


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
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
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
    public function setAttachmentsAttribute($value)
    {
        $attribute_name = "attachments";
        $disk = "public";
        $destination_path = "media/ordernotes/" . date("Y/F/d");

        if(!file_exists(public_path($destination_path))) {
            mkdir(public_path($destination_path), 0777, true);
        }
        
        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
