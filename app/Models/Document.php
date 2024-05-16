<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable=[
      'name','description','files','user_id','department_id'
    ];
    //many to many
    public function category()
{
    return $this->beLongsToMany(category::class,'category_document');
}
    //one to many
    public function UserDocument(){

        return $this->beLongsTo(User::class);
    }
    public function Department(){

       return $this->beLongsTo(Department::class);
    }
//morph
public function Tags()
{
    return $this->morphmany(Tags::class,'tagable');
}
}
