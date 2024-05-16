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
//many to many
    public function DocumentsCategory()
    {
        return $this->beLongsToMany(Document::class,'category_document');
    }
}
