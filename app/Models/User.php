<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'username','email','password','role_id'
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function post(){
        return $this->hasMany(Post::class);
    }
    public function comment(){
        return $this->hasMany(Comment::class);
    }
}
