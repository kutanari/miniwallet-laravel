<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    public $incrementing = false;
    protected $keyType = 'string';

    public function getLatestAmount(): int
    {
        $latest_transaction = Transaction::where('wallet_id', $this->id)->orderBy('created_at', 'desc')->first();
        return (int)$latest_transaction->amount_to ?? 0;
    }
}
