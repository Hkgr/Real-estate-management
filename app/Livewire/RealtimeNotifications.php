<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RealtimeNotifications extends Component
{
    public int $perPage = 4;

    public function getNotificationsProperty()
    {
        $user = Auth::user();

        if (! $user) {
            return collect();
        }

        return $user->notifications()
            ->latest()
            ->take($this->perPage)
            ->get();
    }

    public function getUnreadCountProperty(): int
    {
        $user = Auth::user();

        if (! $user) {
            return 0;
        }

        return $user->unreadNotifications()->count();
    }

    public function render()
    {
        return view('livewire.realtime-notifications');
    }
}
