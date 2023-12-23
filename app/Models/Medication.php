<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = ["scientific_name", 'commercial_name', "cat", "manufacturer", "quantity", "expire_date", "price"];
    protected $hidden = ["created_at", "updated_at", "id"];
    public function requests()
    {
        return $this->belongsToMany(Req::class, "med_req_pivot")->withPivot('quantity');
    }


    public function pharmacists()
    {
        return $this->belongsToMany(Phar::class, 'med_phar');
    }
}
