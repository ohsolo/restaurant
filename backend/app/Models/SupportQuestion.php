<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class SupportQuestion extends Model
{
    use Flagable;
    protected $table      = 'support_questions';
    protected $primaryKey = 'support_question_id';
    protected $keyType    = 'string';
    public $incrementing  = false;

    protected $appends = [
        'active'
    ];

    public const FLAG_STATUS_ACTIVE = 1;
  
    public function getActiveAttribute()
    {
        return ($this->flags & self::FLAG_STATUS_ACTIVE) == self::FLAG_STATUS_ACTIVE;
    }
}
