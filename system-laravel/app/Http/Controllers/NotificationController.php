<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $student = session('student');
        $studentId = $student->id ?? $student['id'];

        $notifications = Notification::where('user_id', $studentId)
            ->where('user_type', 'student')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $unreadCount = Notification::where('user_id', $studentId)
            ->where('user_type', 'student')
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    public function markRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function markAllRead()
    {
        $student = session('student');
        $studentId = $student->id ?? $student['id'];

        Notification::where('user_id', $studentId)
            ->where('user_type', 'student')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}