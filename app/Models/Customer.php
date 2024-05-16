<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $prefix_id=2014;
    protected $fillable = [
        'name',
        'customer_id', // prefix : 2014  increamenting id : 1 2 3... so on
        'address',
        'phone',
        'email',
        'created_by',
        'created_at',
        'updated_at',
        'status'

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
    public function getCustomerId()
    {

        $customer = new Customer(); // Create a new instance
        $maxId = $customer->withTrashed()->max('id'); // Exclude soft-deleted records

        //dd($maxId );
        if ($maxId !== null) {
            $maxId =($maxId + 1);
        }

        return  ($this->prefix_id * 10) + $maxId;
    }

}
