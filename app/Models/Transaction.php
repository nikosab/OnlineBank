<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'sender',
            'receiver',
            'amount',
            'currency_code'
        ];

    public function senderAccount(): BelongsTo
    {
        return $this->belongsTo(
            Account::class,
            'sender',
            'number'
        );
    }

    public function receiverAccount()
    {
        return $this->belongsTo(
            Account::class,
            'receiver',
            'number'
        );
    }
}
