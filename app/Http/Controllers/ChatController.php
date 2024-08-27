<?php

namespace App\Http\Controllers;
use App\Models\Chat;
use App\Models\User;
use App\Events\ChatEvent;
use Illuminate\Http\Request;
use App\Services\UserService;

class ChatController extends Controller
{
    //
    public function chat_form($user_id)
    {
        $resiver=User::where('id',$user_id)->first();;
        return response()->json([
        'user_resiver'=>$resiver,
        'status'=>'resive'
        ]);
    }
          public function send_message(Request $request,$user_id)

          {

              $toUser=User::where('id',$user_id)->first();
              $resiver=$toUser->id;
             $chat=Chat::create([
              'sender_id' =>auth('api')->user()->id,
              'resevire_id'=>$toUser->id,
              'message'=>$request->message
             ]);
             \broadcast(new ChatEvent($chat,$resiver));
             return response()->json([
               'chat'=>$chat
             ]);
          }

}
