<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency_code',
        'type',
        'number',
        'balance'
    ];

    protected $guarded = [
        'number',
        'balance',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): HasMany
    {
        return $this->hasMany(
            Transaction::class,
            'sender',
            'number'
        )->orWhere(
            'receiver',
            $this->number);
    }
}
