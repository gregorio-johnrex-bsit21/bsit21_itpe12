<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect('/student');
});

require __DIR__.'/student.php';
require __DIR__.'/supervisor.php';
require __DIR__.'/admin.php';

// ============================================================
// Chat routes — file-based, read indexes tracked server-side
// ============================================================

function getChatFile(string $conversation): string {
    return 'chat_' . preg_replace('/[^a-zA-Z0-9_\-]/', '_', $conversation) . '.json';
}

function readChatData(string $conversation): array {
    $file = getChatFile($conversation);
    if (!Storage::exists($file)) return ['messages' => [], 'readBy' => []];
    $data = json_decode(Storage::get($file), true);
    // Legacy format migration
    if (!isset($data['messages'])) {
        return ['messages' => array_values($data ?? []), 'readBy' => []];
    }
    if (!isset($data['readBy'])) $data['readBy'] = [];
    return $data;
}

function writeChatData(string $conversation, array $data): void {
    Storage::put(getChatFile($conversation), json_encode($data));
}

// POST /send-message
Route::post('/send-message', function (Request $request) {
    $conversation = $request->input('conversation', 'default');
    $sender       = $request->input('sender', 'Unknown');
    $data         = readChatData($conversation);

    $data['messages'][] = [
        'message' => $request->input('message'),
        'sender'  => $sender,
        'time'    => now()->format('h:i A'),
    ];

    if (count($data['messages']) > 100) {
        $data['messages'] = array_slice($data['messages'], -100);
        foreach ($data['readBy'] as $role => $index) {
    $data['readBy'][$role] = max(0, $index - $excess);
}
    }

    // Auto-mark sender as read so their own message doesn't count as unread for them
    $data['readBy'][$sender] = count($data['messages']);

    writeChatData($conversation, $data);
    return response()->json(['status' => 'ok']);
});

// GET /get-messages?conversation=Marcus_Wright&role=Student&after=0
Route::get('/get-messages', function (Request $request) {
    $conversation = $request->query('conversation', 'default');
    $role         = $request->query('role', null);
    $after        = (int) $request->query('after', 0);
    $data         = readChatData($conversation);
    $messages     = $data['messages'];
    $total        = count($messages);
    $unread       = 0;

    if ($role) {
        $readIndex = $data['readBy'][$role] ?? 0;
        $unread    = max(0, $total - $readIndex);
    }

    return response()->json([
        'messages' => array_values(array_slice($messages, $after)),
        'total'    => $total,
        'unread'   => $unread,
    ]);
});

// POST /mark-read  { conversation, role }
Route::post('/mark-read', function (Request $request) {
    $conversation = $request->input('conversation', 'default');
    $role         = $request->input('role');
    $data         = readChatData($conversation);
    $data['readBy'][$role] = count($data['messages']);
    writeChatData($conversation, $data);
    return response()->json(['status' => 'ok']);
});

// GET /get-conversations?names[]=Marcus_Wright&role=Supervisor
Route::get('/get-conversations', function (Request $request) {
    $conversations = $request->query('names', []);
    $role          = $request->query('role', 'Supervisor');
    $result        = [];

    foreach ($conversations as $name) {
        $data      = readChatData($name);
        $messages  = $data['messages'];
        $readIndex = $data['readBy'][$role] ?? 0;
        $unread    = max(0, count($messages) - $readIndex);
        $last      = count($messages) > 0 ? end($messages) : null;

        $result[$name] = [
            'last'   => $last,
            'unread' => $unread,
            'total'  => count($messages),
        ];
    }

    return response()->json($result);
});

// POST /clear-messages
Route::post('/clear-messages', function (Request $request) {
    $conversation = $request->input('conversation', 'default');
    writeChatData($conversation, ['messages' => [], 'readBy' => []]);
    return response()->json(['status' => 'cleared']);
});