<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use Auth;
use App\Events\NewMessage;

class ApiController extends Controller {

	public function getFriends(){
		$allUsers = User::where('id', '!=', Auth::user()->id)->get();
		return $allUsers;
	}

	public function getMessages($id){
		$messages = Message::where(function($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })
        ->get();
        return $messages;
	}
    public function sendMsg(Request $r){
        $message = Message::create([
            'from' => auth()->id(),
            'to' => $r->friend_id,
            'text' => $r->text
        ]);
        broadcast(new NewMessage($message));
        return response()->json($message);

    }
}