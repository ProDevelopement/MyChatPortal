<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use Auth;
use App\Events\NewMessage;

class ApiController extends Controller {

	public function getFriends(){
        // get all users except the authenticated one
        $friends = User::where('id', '!=', auth()->id())->get();

        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        // add an unread key to each contact with the count of unread messages
        $friends = $friends->map(function($friends) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $friends->id)->first();
            $friends->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $friends;
        });
        return response()->json($friends);
    }

	public function getMessages($id){
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);
        
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