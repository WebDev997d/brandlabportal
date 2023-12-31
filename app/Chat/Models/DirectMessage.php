<?php

namespace App\Chat\Models;

use Illuminate\Database\Eloquent\Model;
use App\Base\Models\User;

class DirectMessage extends Model
{
    protected $fillable = ['body', 'sender_id', 'attachment_id', 'receiver_id', 'read_at'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function user()
    {
        return $this->sender();
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
