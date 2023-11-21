<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modals extends Model
{
    use HasFactory;
    public function bodyParts(){
        return $this->hasMany(BodyParts::class,'model_id','id');
    }
}
