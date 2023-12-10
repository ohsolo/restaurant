<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Flagable;

class NotificationUser extends Model
{
    use Flagable;
    protected $table = 'notification_users';
    protected $primaryKey = 'notification_user_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $appends = [
        'read'
    ];

    public const FLAG_READ = 1;

    public function getReadAttribute() {
        return ($this->flags & self::FLAG_READ) == self::FLAG_READ;
    }

    public function notif ()
    {
        return $this->hasOne('App\Models\Notification', 'notification_id', 'notification_id');
    }
}
