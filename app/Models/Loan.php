<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
class Loan extends Model
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $prefix_id='L-';
    protected $fillable = [
        'type',
        'customer_acc_id', // prefix : 2014  increamenting id : 1 2 3... so on
        'amount',
        'rate',
        'duration',
        'assigned_to',
        'no_of_emi',
        'amount_of_emi',
        'ti',
        'pa',
        'loan_verified_at',
        'loan_id','status'
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
                $latestId = intval(substr($latestCustomer->loan_id, 2)); // Extract numeric part
                $newId = 'L-' . str_pad($latestId + 1, 7, '0', STR_PAD_LEFT); // Increment and format
            } else {
                $newId = 'L-0000001'; // If no records, start from 1
            }

            $model->loan_id = $newId;
        });
    }

}
