<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintingModule extends Model
{
    use HasFactory;
    protected $fillable =['module_name','parent_id','category_id','active'];



    public function printingModuleOptions()
    {
        $data = [ null => '-- Select --'];
        $result = $this->pluck('module_name', 'id');
        if($result->count() > 0) {
            $data = $data + $result->toArray();
        }

        return $data;
    }


    public function store($inputs, $id = null)
    {
        if($id)
        {
            $printing_modules= $this->findOrFail($id);
            return $printing_modules->update($inputs);
        }

        return $this->create($inputs)->id;
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }




}
