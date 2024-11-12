<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Testimony;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class TestimonyObserver
{
    /**
     * Handle the Testimony "created" event.
     */
    public function created(Testimony $testimony): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang sedang login
        $client = $testimony->client;
        $postedBy = Auth::user()->name; 

        foreach ($recipients as $recipient) {
            Notification::make()
                ->success()
                ->client('New Testimony Posted')
                ->body("Testimony from '{$client}' was posted by {$postedBy}.")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(route('filament.admin.resources.testimonies.edit', $testimony->id), shouldOpenInNewTab: true),
                ])
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Testimony "updated" event.
     */
    public function updated(Testimony $testimony): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang sedang login
        $client = $testimony->client;
        $postedBy = Auth::user()->name; 

        foreach ($recipients as $recipient) {
            Notification::make()
                ->success()
                ->title('Testimony Updated')
                ->body("Testimony from '{$client}' was updated by {$postedBy}.")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(route('filament.admin.resources.testimonies.edit', $testimony->id), shouldOpenInNewTab: true),
                ])
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Testimony "deleted" event.
     */
    public function deleted(Testimony $testimony): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang sedang login
        $client = $testimony->client;
        $postedBy = Auth::user()->name; 

        foreach ($recipients as $recipient) {
            Notification::make()
                ->success()
                ->title('New Testimony Deleted')
                ->body("Testimony from '{$client}' was deleted by {$postedBy}.")
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Testimony "restored" event.
     */
    public function restored(Testimony $testimony): void
    {
        //
    }

    /**
     * Handle the Testimony "force deleted" event.
     */
    public function forceDeleted(Testimony $testimony): void
    {
        //
    }
}
