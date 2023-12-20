<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;
    public function requests(){
        return $this->belongsToMany(Req::class,"med_req_pivot");
    }
}
