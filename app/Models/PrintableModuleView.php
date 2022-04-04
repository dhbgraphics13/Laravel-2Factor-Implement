<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintableModuleView extends Model
{
    use HasFactory;
    protected $table = 'printing_module_view';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
