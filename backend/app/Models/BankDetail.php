<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class BankDetail extends Model
{
    
    use Flagable;
    protected $table = 'bank_details';
    protected $primaryKey = 'bank_detail_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = [
        'id', 'flags', 'password', 'reset_token'
    ];
}