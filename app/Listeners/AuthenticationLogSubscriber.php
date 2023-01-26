<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Auth\Events;
use App\Models\AuthenticationLog;
use Illuminate\Support\Facades\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthenticationLogSubscriber
{
    public function loginSuccessful(Events\Login $event): void
    {
        AuthenticationLog::create([
            'event' => 'LOGIN',
            'email' => $event->user->email,
            'ip' => request()->getClientIp()
        ]);
    }

    public function registered(Events\Registered $event): void
    {
        AuthenticationLog::create([
            'event' => 'REGISTRATION',
            'email' => $event->user->email,
            'ip' => request()->getClientIp()
        ]);
    }

    public function loginFailed(Events\Failed $event): void
    {
        AuthenticationLog::create([
            'event' => 'LOGIN_FAILED',
            'email' => $event->credentials['email'],
            'ip' => request()->getClientIp()
        ]);
    }

    public function logout(Events\Logout $event): void
    {
        AuthenticationLog::create([
            'event' => 'LOGOUT',
            'email' => $event->user->email,
            'ip' => request()->getClientIp()
        ]);
    }

    public function subscribe(Event $events)
    {
        return [
            Events\Login::class => 'loginSuccessful',
            Events\Logout::class => 'logout',
            Events\Registered::class => 'registered',
            Events\Failed::class => 'loginFailed'
        ];
    }
}
