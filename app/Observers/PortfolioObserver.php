<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class PortfolioObserver
{
    /**
     * Handle the Portfolio "created" event.
     */
    public function created(Portfolio $portfolio): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang sedang login
        $title = $portfolio->title;
        $postedBy = Auth::user()->name; 

        foreach ($recipients as $recipient) {
            Notification::make()
                ->success()
                ->title('New Portfolio Posted')
                ->body("Portfolio with title '{$title}' was posted by {$postedBy}.")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(route('filament.admin.resources.portfolios.edit', $portfolio->slug), shouldOpenInNewTab: true),
                ])
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Portfolio "updated" event.
     */
    public function updated(Portfolio $portfolio): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang sedang login
        $title = $portfolio->title;
        $postedBy = Auth::user()->name; 

        foreach ($recipients as $recipient) {
            Notification::make()
                ->warning()
                ->title('Portfolio Updated')
                ->body("Portfolio with title '{$title}' was updated by {$postedBy}.")
                ->actions([
                    Action::make('view')
                        ->button()
                        ->url(route('filament.admin.resources.portfolios.edit', $portfolio->slug), shouldOpenInNewTab: true),
                ])
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Portfolio "deleted" event.
     */
    public function deleted(Portfolio $portfolio): void
    {
        // Mendapatkan semua admin dan superadmin
        $recipients=User::whereIn('role', ['admin', 'superadmin'])->get();

        // Ambil nama pengguna yang sedang login
        $title = $portfolio->title;
        $postedBy = Auth::user()->name; 

        foreach ($recipients as $recipient) {
            Notification::make()
                ->danger()
                ->title('Portfolio Deleted')
                ->body("Portfolio with title '{$title}' was deleted by {$postedBy}.")
                ->sendToDatabase($recipient);
        }
    }

    /**
     * Handle the Portfolio "restored" event.
     */
    public function restored(Portfolio $portfolio): void
    {
        //
    }

    /**
     * Handle the Portfolio "force deleted" event.
     */
    public function forceDeleted(Portfolio $portfolio): void
    {
        //
    }
}
