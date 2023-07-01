<?php

namespace App\Models;

use App\Helpers\UtilityHelper;
use App\Traits\HasStatus;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\HasUploadFields;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @property-read string $type_html
 */
class Order extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use CrudTrait;
    use HasFactory;
    use HasStatus;
    use HasUploadFields;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public const DELIVERIES = [
        'dine' => 'Dine',
        'pickup' => 'TakeOut',
        'delivery' => 'Home Delivery',
    ];

    public const PRIORITIES = [
        'lowest' => 'Lowest',
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'highest' => 'highest'
    ];

    protected $table = 'orders';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'total_item' => 'float',
        'total_amount' => 'float',
        'subtotal' => 'float',
        'tax' => 'float',
        'discount' => 'float',
        'delivery_charge' => 'float',
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
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function addressBook()
    {
        return $this->belongsTo(AddressBook::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderNotes()
    {
        return $this->hasMany(OrderNote::class);
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
        return UtilityHelper::platformIcon($this->platform);
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setAttachmentsAttribute($value)
    {
        $attribute_name = "attachments";
        $disk = "public";
        $destination_path = "media/orders/" . date("Y/F/d");

        if(!file_exists(public_path($destination_path))) {
            mkdir(public_path($destination_path), 0777, true);
        }
        
        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
