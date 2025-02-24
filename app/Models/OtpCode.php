<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;


class OtpCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'type',
        'usage',
        'expires_at',
        'is_used'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    static function generateCode(): string
    {
        if (App::environment('production')) {
            return mt_rand(1000, 9999);
        } else {
            return "1234";
        }
    }
}
