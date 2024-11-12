<?php

namespace App\Filament\User\Pages;

use Filament\Forms;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class ChangePassword extends Page
{
    protected static ?string $navigationLabel = 'Change Password';
    
    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    protected static string $view = 'filament.user.pages.change-password';

    protected static ?int $navigationSort = 10;

     // Deklarasi properties untuk validasi
     public $current_password;
     public $new_password;
     public $new_password_confirmation;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('current_password')
                ->label('Kata Sandi Saat Ini')
                ->password()
                ->revealable()
                ->required()
                ->rules(['required', 'string']),
                
            Forms\Components\TextInput::make('new_password')
                ->label('Kata Sandi Baru')
                ->password()
                ->revealable()
                ->required()
                ->rules(['required', 'string', Rules\Password::defaults()]),
                
            Forms\Components\TextInput::make('new_password_confirmation')
                ->label('Konfirmasi Kata Sandi Baru')
                ->password()
                ->revealable()
                ->required()
                ->same('new_password')
                ->rules(['required', 'string']),
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        if (!$user instanceof User) {
            throw new ValidationException('Pengguna tidak ditemukan.'); // Cek apakah pengguna ada
        }

        if (!Hash::check($this->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Kata sandi saat ini tidak cocok.',
            ]);
        }

        // Memperbarui password pengguna
        $user->password = bcrypt($this->new_password); // Mengatur password baru
        $user->save(); // Menyimpan perubahan

        // Notifikasi berhasil
        Notification::make()
            ->title('Sukses')
            ->body('Kata sandi berhasil diubah!')
            ->success()
            ->send();
    }
}
