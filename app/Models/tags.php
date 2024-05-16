<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tags extends Model
{
    use HasFactory;
    protected $fillable=[
     'tag','user_id'
    ];
    public function TagToUser()
    {
        return $this->belongsTo(User::class);
    }
}
