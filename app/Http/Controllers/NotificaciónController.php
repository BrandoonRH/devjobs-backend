<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificaciónController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $notifications = auth()->user()->unreadNotifications;

        //limpiar Notificaciones
        //auth()->user()->unreadNotifications->markAsRead();

        //return response()->json([$notifications], 200);
        return [
            "notifications" => $notifications,
            "last" => auth()->user()->unreadNotifications->count()
        ];
    }
}
