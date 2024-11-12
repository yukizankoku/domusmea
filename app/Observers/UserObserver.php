<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang bergabung
        $name = $user->name;

        foreach ($recipients as $recipient) {
            Notification::make()
                ->success()
                ->title('New User Registered')
                ->body("User with Name '{$name}' was registered.")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(route('filament.admin.resources.users.edit', $user->username), shouldOpenInNewTab: true),
                ])
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // 
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang dihapus
        $name = $user->name;
        // Ambil nama pengguna yang sedang login
        $deletedBy = Auth::user()->name; 

        foreach ($recipients as $recipient) {
            Notification::make()
                ->success()
                ->title('User Profile Updated')
                ->body("User with Name '{$name}' was updated by {$deletedBy}.")
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
