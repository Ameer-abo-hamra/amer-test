<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Phar extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = ["username", "password", "phone_number"];

    protected $hidden = ["created_at", "updated_at"];
    public function requests()
    {
        return $this->hasMany(Req::class, "phar_id");
    }


    public function favorites() {

        return $this -> belongsToMany(Medication::class , "med_phar");
    }



    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
