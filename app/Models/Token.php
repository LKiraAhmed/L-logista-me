<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Token extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'token'];
    public static function generateToken($userId)
    {
        $token = Str::random(40) . mt_rand(1000, 9999); 
        $hashedToken = hash('sha256', $token);
        self::create([
            'user_id' => $userId,
            'token' => $hashedToken,
        ]);
    
        return $token; 
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
