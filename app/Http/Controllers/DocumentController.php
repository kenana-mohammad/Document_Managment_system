<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\category;
use app\Helpers\helper;
use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Document\DocumentStoreRequest;
use App\Http\Requests\Document\DocumentUpdateRequest;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $document=Cache::remember('document', 60, function () {
 return Document::select('name','files')->get();
        });
        return response()->json([
            'status'=>'list',
            'document'=>$document
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentStoreRequest $request)
    {
        //
        try{
            DB::beginTransaction();
            if($request->hasfile('files'))
            {
                $extension = $request->file('files')->getClientOriginalExtension();

                $filename = Str::random(20).'.'.$extension;
                $path = $request->file('files')->storeAs('files', $filename, 'public');
                $files = $path;
        }
                  //تخزين النوع تلقاىيا بناء على اللاحقة


          $category=Category::where('mimeType',$extension)->firstOrFail();

                  $document=Document::create([
                      'name' =>$request->name,
                      'description'=>$request->description,
                      'user_id'=>Auth::user()->id,
                      'category_id'=> $category->id,
                      'department_id'=>$request->department_id,
                      'files'=> $files,
                  ]);

                  DB::commit();
                  return response()->json([
                    'status'=>'Add',
                    'document'=>$document,
                  ]);

        }
        catch(Throwable $th){
            DB::rollback();
            Log::debug($th);
            Log::error($th->getMessage());
            return response()->json([
                'status' => 'error',
            ]);

    }
    }
    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DocumentUpdateRequest $request, Document $document)
    {
        //
        try{
            DB::beginTransaction();
       $newData=[];
        if(isset($request->name))
        {
            $newData['name']=$request->name;
        }
        if(isset($request->description))
        {
            $newData['description']=$request->description;
        }
        if(isset($request->department_id))
        {
            $newData['department_id']=$request->department_id;
        }
            if($request->hasfile('files'))
            {
                $extension = $request->file('files')->getClientOriginalExtension();

                $filename = Str::random(20).'.'.$extension;

                $path = $request->file('files')->storeAs('files', $filename, 'public');
                $files = $path;


            $newData['files'] = $files ;
            $category = Category::where('mimeType',$extension)->FirstOrFail();

            $newData['category_id']= $category->id;

         }





DB::commit();
   if( Auth::user()->id !== $document->user_id)
{
    return response()->json([
        'status'=>'not allowed',
    ]);
}
$document->update($newData);
return response()->json([
  'status' =>'update',
  'document'=>$document
]);
    }
    catch(Throwable $th){
        DB::rollback();
        Log::debug($th);
        Log::error($th->getMessage());
        return response()->json([
            'status'=>'error',
        ]);
    }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
        $document =Document::find($id);



        if (Auth::user()->id != $document->user_id) {
            return response()->json([
                'status' => 'not Allowed delete'
            ]);
        }
        if (!$document) {
            return response()->json([
                'status' => 'not found'
            ]);
        }

$document->delete();

        return response()->json([
            'status' => 'delete'
        ]);
    }
    //Download file
    public function Download($id)
    {

        $document = Document::find($id);

        $filePath = storage_path('app/public/' . $document->files);
        return response()->download($filePath);

    }
}
