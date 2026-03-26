<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    /**
     * GET /get-messages
     *
     * Query params:
     *   conversation  – e.g. 'Marcus_Wright'
     *   after         – return only messages with id > this value (0 = all)
     *   role          – caller's role: 'Student' | 'Supervisor'
     *
     * Response:
     * {
     *   "messages": [ { "id", "sender", "message", "time" }, … ],
     *   "total":    <int>,   // total messages in conversation (used as next `after`)
     *   "unread":   <int>    // messages NOT sent by caller that are unread
     * }
     */
    public function getMessages(Request $request): JsonResponse
    {
        $conversation = $request->query('conversation', '');
        $after        = (int) $request->query('after', 0);
        $role         = $request->query('role', 'Student');

        // All messages in this conversation (for `total` count)
        $total = Message::where('conversation', $conversation)->count();

        // Messages after the given index (used by the chat window poller)
        $messages = Message::where('conversation', $conversation)
            ->orderBy('id')
            ->skip($after)
            ->take(100)
            ->get()
            ->map(fn($m) => [
                'id'      => $m->id,
                'sender'  => $m->sender,
                'message' => $m->message,
                'time'    => $m->time,
            ]);

        // Unread = messages sent by the OTHER party that haven't been read
        $unread = Message::where('conversation', $conversation)
            ->where('sender', '!=', $role)
            ->where('is_read', false)
            ->count();

        return response()->json([
            'messages' => $messages,
            'total'    => $total,
            'unread'   => $unread,
        ]);
    }
    
    

    public function uploadMedia(Request $request)
    {
         $request->validate(['file' => 'required|file|mimes:jpeg,png,gif,mp4,webm,ogg|max:20480']);
         $path = $request->file('file')->store('chat-media', 'public');
         return response()->json(['url' => Storage::url($path)]);
    }




    /**
     * POST /send-message
     *
     * Body (JSON):
     * {
     *   "conversation": "Marcus_Wright",
     *   "sender":       "Student",
     *   "message":      "Hello!"
     * }
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'conversation' => 'required|string|max:255',
            'sender'       => 'required|string|max:50',
            'message'      => 'required|string|max:5000',
        ]);

        $msg = Message::create([
            'conversation' => $validated['conversation'],
            'sender'       => $validated['sender'],
            'message'      => $validated['message'],
            'is_read'      => false,
        ]);

        return response()->json([
            'id'      => $msg->id,
            'sender'  => $msg->sender,
            'message' => $msg->message,
            'time'    => $msg->time,
        ], 201);
    }

    /**
     * POST /mark-read
     *
     * Body (JSON):
     * {
     *   "conversation": "Marcus_Wright",
     *   "role":         "Student"
     * }
     *
     * Marks all messages sent by the OTHER party as read.
     */
    public function markRead(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'conversation' => 'required|string|max:255',
            'role'         => 'required|string|max:50',
        ]);

        $updated = Message::where('conversation', $validated['conversation'])
            ->where('sender', '!=', $validated['role'])
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['marked' => $updated]);
    }
    /**
 * GET /get-conversations
 *
 * Query param: names[] = ['Marcus_Wright', 'Sarah_Jenkins']
 *
 * Returns last message + unread count per conversation (for supervisor previews/badges).
 */
public function getConversations(Request $request): JsonResponse
{
    $names = $request->query('names', []);
    $result = [];

    foreach ($names as $conversation) {
        $last = Message::where('conversation', $conversation)
            ->orderBy('id', 'desc')
            ->first();

        $unread = Message::where('conversation', $conversation)
            ->where('sender', '!=', 'Supervisor')
            ->where('is_read', false)
            ->count();

        $result[$conversation] = [
            'last'   => $last ? [
                'message' => $last->message,
                'sender'  => $last->sender,
                'time'    => $last->time,
            ] : null,
            'unread' => $unread,
        ];
    }

    return response()->json($result);
}
}


