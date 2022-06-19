<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const TRANSACTION_TYPE_DEPOSITS = 1;
    const TRANSACTION_TYPE_WITHDRAWALS = 2;
    // TODO: add more transaction types like debit or credit etc.

    const TRANSACTION_STATUS_PENDING = 0;
    const TRANSACTION_STATUS_COMPLETED = 1;
    const TRANSACTION_STATUS_FAILED = -1;

    const TRANSACTION_STATUS_LABEL = [
        self::TRANSACTION_STATUS_PENDING => 'pending',
        self::TRANSACTION_STATUS_COMPLETED => 'completed',
        self::TRANSACTION_STATUS_FAILED => 'failed',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
}
