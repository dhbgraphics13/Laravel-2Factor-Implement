<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $table = ['user_profile'];
    protected $fillable = ['user_id','old_email'];

    public function store($inputs, $id = null)
    {
        if($id)
        {
            $user_profile = $this->findOrFail($id);
            return $user_profile->update($inputs);
        } else {
            return $this->create($inputs)->id;
        }
    }

}
