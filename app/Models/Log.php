<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'domaine', 'context', 'date'];

    public function isUserStill()
    {
        return User::find($this->user_id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createLog($userId, $domain, $context)
    {
        self::create([
            'user_id' => $userId,
            'domaine' => $domain,
            'context' => $context,
        ]);
    }

}
