<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'login_at',
        'ip_address',
        // Add more fillable fields as needed
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
