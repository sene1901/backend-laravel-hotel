<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Récupérer toutes les notifications de l'utilisateur
    public function index(Request $request)
    {
        $user = $request->user();

        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    // Marquer une notification comme lue
    public function markAsRead($id, Request $request)
    {
        $notification = Notification::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $notification->update(['read' => true]);

        return response()->json(['message' => 'Notification marquée comme lue']);
    }
}
