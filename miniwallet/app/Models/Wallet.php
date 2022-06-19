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
}
