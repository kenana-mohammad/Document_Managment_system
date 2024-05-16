<?php
namespace App\Helpers;

function handleException(\Throwable $th)
{
    DB::rollback();
    Log::debug($th);
    Log::error($th->getMessage());
    return response()->json([
        'status' => 'error',
    ]);
}

?>
