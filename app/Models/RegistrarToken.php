<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrarToken extends Model
{
    use HasFactory;
    protected $fillable=['expo_token','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
