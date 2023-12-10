<?php

namespace App\Models;
use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingInfo extends Model
{
    use Flagable;
    protected $table      = 'pending_infos';
    protected $primaryKey = 'pending_info_id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $appends = [
        'active'
    ];

    public const STATUS_APPROVED         = 'approved';
    public const STATUS_REJECTED         = 'rejected';
    public const STATUS_PENDING          = 'pending';

    public const FLAG_STATUS_ACTIVE = 1;
  
    public function getActiveAttribute()
    {
        return ($this->flags & self::FLAG_STATUS_ACTIVE) == self::FLAG_STATUS_ACTIVE;
    }
}
