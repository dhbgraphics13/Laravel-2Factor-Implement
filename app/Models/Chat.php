<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'order_id',
            'user_id',
            'text'
        ];


    public function store($inputs, $id = null)
    {
        if($id)
        {
            $chats = $this->findOrFail($id);
            return $chats->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }


    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
