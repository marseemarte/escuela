<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke()
    {
        Log::info('Logout action called', [
            'user_id' => Auth::id(),
            'session_id' => Session::getId()
        ]);

        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        Log::info('Logout completed successfully');

        return redirect('/');
    }
}
