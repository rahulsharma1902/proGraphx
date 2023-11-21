<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyParts extends Model
{
    use HasFactory;
    public function accents(){
        return $this->hasMany(Accent::class,'body_part_id','id');
    }
}
