<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=[
     'mimeType'
    ];
//one to many
    public function DocumentsCategory()
    {
        return $this->hasMany(Document::class);
    }
}
