<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'category_id',
        'printing_modules',
        'details',
        'quantity',
        'size_height',
        'size_width',
        'price'
    ];

    public function store($inputs, $id = null)
    {
        if($id)
        {
            $order_details = $this->findOrFail($id);
            return $order_details->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }


    public function saveMultiple($data)
    {
        $this->insert($data);
    }



    public function Order()
    {
        return $this->belongsTo(Order::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
