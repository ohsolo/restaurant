<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use Flagable,
        HasFactory;
    protected $table = 'branches';
    protected $primaryKey = 'branch_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $hidden = [
        'id'
    ];

    protected $appends = [
        'active'
    ];

    public const FLAG_ACTIVE = 1;

    public function getActiveAttribute() {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }

    public function city ()
    {
        return $this->hasOne('App\Models\City', 'city_id', 'city_id');
    }

    public function orders ()
    {
        return $this->hasOne('App\Models\Order', 'branch_id', 'branch_id');
    }

}
