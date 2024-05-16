<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Department\DepartmentStoreRequest;
use App\Http\Requests\Department\DepartmentupdateRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $department=Cache::remember('department', 60, function () {
        return Department::all();
        });

        return response()->json([
            'status'=>'list of Department',
          'department'=>$department
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentStoreRequest $request)
    {
        //
        try{
        $request->validated();
        $department=Department::create([
          'name'=>$request->name,
        ]);
        return response()->json([
            'status'=>'Add',
            'Department'=>$department
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
    public function show(Department $department)
    {
        //
        return response()->json([
        'status'=>'Show',
        'department'=>$department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentupdateRequest $request, Department $department)
    {
        //
        try{

            $newData=[];
            if(isset($request->name)){
              $newData['name']=$request->name;
            }
            $department->update($newData);
            return response()->json([
             'status'=>'update',
             'department'=>$department,
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
    public function destroy(Department $department)
    {
        //
        $department->delete();
        return response()->json([
            'status'=>'delete'
        ]);
    }
}
