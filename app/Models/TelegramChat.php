<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramChat extends Model
{
    protected $fillable = [
      'chat_id',
      'title',
      'type',
      'all_members_are_administrators',
    ];

    public function messages()
    {
        return $this->hasMany(TelegramChatMessages::class, 'chat_id', 'chat_id');
    }
}
