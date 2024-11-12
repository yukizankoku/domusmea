<?php

namespace App\Filament\Pages;

use Filament\Forms;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class Profile extends Page
{
    protected static ?string $navigationLabel = 'Profile';
    
    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static string $view = 'filament.pages.profile';

    protected static ?int $navigationSort = 9;

    public $name;
    public $username;
    public $email;
    public $phone;
    public $current_password;

    public function mount()
    {
        // Isi form dengan data user yang sedang login
        $this->form->fill([
            'name' => Auth::user()->name,
            'username' => Auth::user()->username,
            'email' => Auth::user()->email,
            'phone' => Auth::user()->phone,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('username')
                ->label('Username')
                ->required()
                ->rules([
                    Rule::unique('users')->ignore(Auth::id()),  // Mengabaikan ID pengguna yang sedang login
                ]),
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->required()
                ->email()
                ->rules([
                    Rule::unique('users')->ignore(Auth::id()),  // Mengabaikan ID pengguna yang sedang login
                ]),
            Forms\Components\TextInput::make('phone')
                ->label('Phone')
                ->required()
                ->rules([
                    Rule::unique('users')->ignore(Auth::id()),  // Mengabaikan ID pengguna yang sedang login
                ])
                ->tel(),
            Forms\Components\TextInput::make('current_password')
                ->label('Confirm Password')
                ->password()
                ->revealable()
                ->required(),
        ];
    }

    public function submit(): void
    {
        // Ambil pengguna yang sedang login
        $user = Auth::user();
        
        // Pastikan $user adalah instance dari User
        if (!$user instanceof User) {
            Notification::make()
                ->title('User not found')
                ->danger()
                ->send();
            return;
        }

        // Ambil data dari form
        $data = $this->form->getState();

        // Verifikasi password
        if (!Hash::check($data['current_password'], $user->password)) {
            Notification::make()
                ->title('Password is incorrect')
                ->danger()
                ->send();
            return;
        }

        // Update data user
        $user->update([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ]);

        Notification::make()
            ->title('Profile updated successfully')
            ->success()
            ->send();
    }
}
