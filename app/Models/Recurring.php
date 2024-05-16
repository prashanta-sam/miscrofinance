<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
class Recurring extends Model
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $prefix_id='RD-';
    protected $fillable = [
        'type',
        'customer_acc_id', // prefix : 2014  increamenting id : 1 2 3... so on
        'rd_id',
        'amount',
        'amount_of_emi',
        'rate',
        'duration',
        'no_of_emi',
        'ti',
        'pa',
        'verified_at',
        'assigned_to',
        'status',
        'is_maturity_paid'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];

    protected $dates = ['deleted_at'];
    protected static function boot()
    {
        parent::boot();

        // Generate and set customer ID when creating a new record
        static::creating(function ($model) {
            $latestCustomer = static::latest()->first();

            if ($latestCustomer) {
                $latestId = intval(substr($latestCustomer->rd_id, 3)); // Extract numeric part
                $newId = 'RD-' . str_pad($latestId + 1, 7, '0', STR_PAD_LEFT); // Increment and format
            } else {
                $newId = 'RD-0000001'; // If no records, start from 1
            }

            $model->rd_id = $newId;
        });
    }

}
