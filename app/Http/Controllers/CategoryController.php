<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $category=Category::all();
        return response()->json([
        'category'=>$category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try{
            $request->validated();
            $category=Category::create([
              'mimesType'=>$request->mimesType,
            ]);
            return response()->json([
                'status'=>'Add',
                'category'=>$category
            ]);
            }
           catch(\Throwable $th){
            Log::debug($th);
            $e=\Log::error( $th->getMessage());
            return response()->json([
                'status' =>'error',

              ]);


          }

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        try{

            $newData=[];
            if(isset($request->m)){
              $newData['mimeType']=$request->mimeType;
            }
            $department->update($newData);
            return response()->json([
             'status'=>'update',
             'category'=>$category,
            ]);
        }
        catch(Throwable $th)
        {
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
    public function destroy(Category $category)
    {
        //
    }
}
