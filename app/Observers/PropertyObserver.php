<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class PropertyObserver
{
    /**
     * Handle the Property "created" event.
     */
    public function created(Property $property): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang sedang login
        $title = $property->title;
        $postedBy = Auth::user()->name; 

        foreach ($recipients as $recipient) {
            Notification::make()
                ->success()
                ->title('New Property Posted')
                ->body("Property with title '{$title}' was posted by {$postedBy}.")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(route('filament.admin.resources.properties.edit', $property->code), shouldOpenInNewTab: true),
                ])
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Property "updated" event.
     */
    public function updated(Property $property): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang sedang login
        $title = $property->title;
        $updatedBy = Auth::user()->name; 

        foreach ($recipients as $recipient) {
            Notification::make()
                ->warning()
                ->title('Property Updated')
                ->body("Property with title '{$title}' was updated by {$updatedBy}.")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(route('filament.admin.resources.properties.edit', $property->code), shouldOpenInNewTab: true),
                ])
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Property "deleted" event.
     */
    public function deleted(Property $property): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang sedang login
        $title = $property->title;
        $deletedBy = Auth::user()->name; 

        foreach ($recipients as $recipient) {
            Notification::make()
                ->warning()
                ->title('Property deleted')
                ->body("Property with title '{$title}' was deleted by {$deletedBy}.")
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Property "restored" event.
     */
    public function restored(Property $property): void
    {
        //
    }

    /**
     * Handle the Property "force deleted" event.
     */
    public function forceDeleted(Property $property): void
    {
        //
    }
}
