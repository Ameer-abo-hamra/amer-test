<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Req extends Model
{
    use HasFactory;

    protected $fillable = ["phar_id", "payment_state", "receive_state" , "price" ,"quantity" ,"isUpdated"];

    protected $hidden = ["created_at" , "updated_at"];
    public function medications()
    {
        return $this->belongsToMany(Medication::class, "med_req_pivot") ->withPivot('quantity');
    }

    public function pharmacist()
    {
        return $this->belongsTo(Phar::class, "phar_id");
    }
}
