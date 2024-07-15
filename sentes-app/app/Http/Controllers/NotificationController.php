<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications;

        return view('notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        $notification = auth()->user()->notifications->where('id', $id)->first();

        if ($notification->read_at == null) {
            $notification->markAsRead();
        }

        return redirect($notification->data['route']);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back();
    }

    public function markAsUnread($id)
    {
        $notification = auth()->user()->notifications->where('id', $id)->first();

        if ($notification) {
            $notification->markAsUnread();
        }

        return back();
    }

    public function markAllAsUnread()
    {
        auth()->user()->readNotifications->markAsUnread();

        return back();
    }

    public function delete($id)
    {
        $notification = auth()->user()->notifications->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
        }

        session()->flash('success', 'Notification effacée !');
        return back();
    }

    public function deleteAll()
    {
        auth()->user()->notifications->each(function ($notification) {
            $notification->delete();
        });

        session()->flash('success', 'Toutes les notifications ont été effacées !');
        return back();
    }

    // public function deleteRead()
    // {
    //     auth()->user()->readNotifications->each(function ($notification) {
    //         $notification->delete();
    //     });

    //     session()->flash('success', 'Toutes les notifications lues ont été effacées !');
    //     return redirect(route('notifications.index'));
    // }
}
