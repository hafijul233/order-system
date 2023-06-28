<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOption extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'payment_options';
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
    public function payments() 
    {
        return $this->hasMany(Payment::class);
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
public function getTypeHtmlAttribute()
{
    return match($this->type) {
        'cash' => "<span class='text-success'><i class='la la-cash-register'></i> " . config('constant.payment_type.'. $this->type) . "</span>",
        'bank' => "<span class='text-info'><i class='la la-piggy-bank'></i> " . config('constant.payment_type.'. $this->type) . "</span>",
        'wallet' => "<span class='text-primary'><i class='la la-wallet'></i> " . config('constant.payment_type.'. $this->type) . "</span>",
        default => "<span class='text-warning'><i class='la la-warning'></i>N/A</span>"
    };
}
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
