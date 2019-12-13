<?php

namespace App\Http\Controllers;

use App\Chatmessage;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Events\WebsocketDemoEvent;

class ChatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        broadcast(new WebsocketDemoEvent('some data'));
        return view('/chats');
    }

    public function fetchMessages()
    {
        return Chatmessage::with('user')->get();
    }

    public function sendMessage(Request $request)
    {
        $message = auth()->user()->messages()->create([
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message->load('user')));

        return ['status' => 'success'];
    }
}
