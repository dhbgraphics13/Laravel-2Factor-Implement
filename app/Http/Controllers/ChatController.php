<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $orderID = $request->order_id;
        if($orderID!=null)
        {
            $data =[
                'order_id'  =>$orderID,
                'user_id'   => Auth::user()->id,
                'text'      => $request->text,
            ];

            (new Chat)->store($data);

          //  $order = Order::find($orderID);
            $chats = Chat::where('order_id',$orderID)->orderBy('id','asc')->get();
            $view = View::make('chat.chat_inner', ['chats' => $chats]);
            $contents = $view->render();
            return response()->json(['options'=>$contents]);
        }
        return response()->json(['error'=>'Order not found']); // chat disabled b kar skde a
    }


    public function syncChat(Request $request)
    {
        $orderID = $request->order_id;
       // $order = Order::find($orderID);
        $chats = Chat::where('order_id',$orderID)->orderBy('id','asc')->get();
        $view = View::make('chat.chat_inner', ['chats' => $chats]);
        $contents = $view->render();
        return response()->json(['options'=>$contents]);

    }

}
