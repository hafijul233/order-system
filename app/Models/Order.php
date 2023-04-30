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
 */
class Order extends Model implements Auditable
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
    public const PLATFORMS = [
        'android' => 'Android App',
        'ios' => 'iOS App',
        'website' => 'Web Site',
        'office' => 'System',
        'store' => 'Store',
    ];

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
/*    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }*/

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
        return match ($this->platform) {
            'online' => "<span class='text-success'><i class='la la-globe-asia'></i> " . self::PLATFORMS[$this->platform] . "</span>",
            'offline' => "<span class='text-black-50'><i class='la la-building'></i> " . self::PLATFORMS[$this->platform] . "</span>",
            default => "<span class='text-warning'><i class='la la-warning'></i>N/A</span>"
        };
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
