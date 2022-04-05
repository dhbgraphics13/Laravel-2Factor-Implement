<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'phone',
            'email',
            'address',
            'user_id',
            'status',
            'due_date',
            'payment_method',
            'price',
            'total_price',
            'approved_by',
            'approved_by_information',
            'ready_for_print',
            'printed_by',
            'file',
            'file_print_instructions',
            'picked_by_information','uploaded_by','file_uploader_id'
        ];

    public function store($inputs, $id = null)
    {
        if($id)
        {
            $orders = $this->findOrFail($id);
            return $orders->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

}
