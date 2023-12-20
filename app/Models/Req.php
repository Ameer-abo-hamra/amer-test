<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Req extends Model
{
    use HasFactory;
    public function medications(){
        return $this->belongsToMany(Medication::class,"med_req_pivot");
    }

    public function pharmacist(){
        return $this->belongsTo(Phar::class,"phar_id");
    }
}
