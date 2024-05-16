<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Document;
use Auth;
use App\Helpers\helper;
use App\models\user;
use App\models\tags;

class TagController extends Controller
{
    //
    public function AddTag(Request $request,$id)
    {
        try{
         $document= Document::find($id);
      $tag=  $document->tags()->create(
[
    'user_id'=>Auth::user()->id,
    'tag' =>$request->tag
]

        );
        return response()->json([
        'status'=>"add tag",
         'tag'=>$tag
        ]);
    }
    catch(Throwable $th)
    {
        DB::rollback();
        Log::debug($th);
        Log::error($th->getMessage());
        return response()->json([
            'status'=>'error',
        ]);    }
}
//update Tag
public function updateTag(Request $request,$id)
{
    $Tag=Tags::where('id',$id)->first();
    $newData=[];
    if(isset($request->tag)){
        $newData['tag']=$request->tag;
    }
          if(Auth::user()->id == $Tag->user_id){
              $Tag->update($newData);
          }
          return response()->json([
            'status' => "update",
            'tag'=>$Tag,
          ]);
}
//delete
public function DeleteTag($id)

{
        $tag = Tags::find($id);
        if(Auth::user()->id== $tag->user_id){
            $tag->delete();
            return response()->json([
         'status'=>'delete'
            ]);
        }

}
}
