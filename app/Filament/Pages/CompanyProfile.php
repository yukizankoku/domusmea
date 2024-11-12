<?php

namespace App\Filament\Pages;

use Filament\Forms;
use App\Models\Compro;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class CompanyProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static string $view = 'filament.pages.company-profile';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?int $navigationSort = 5;

    public bool $isReadonly = false;

    public $name, $logo, $about, $address, $phone, $email;
    public $privacy_policy, $privacy_policy_updated_at;
    public $terms_and_conditions, $terms_and_conditions_updated_at;
    public $url_maps, $url_facebook, $url_instagram, $url_linkedin, $url_youtube, $url_tiktok;

    public function mount()
    {
        $userRole = Auth::user()->role;

        if ($userRole === 'admin') {
            $this->isReadonly = true;
        } elseif ($userRole !== 'superadmin') {
            abort(403, 'Unauthorized access');
        }

        $compro = Compro::firstOrNew();

        $this->fillProperties($compro);
    }

    private function fillProperties(Compro $compro)
    {
        $this->name = $compro->name;
        $this->logo = $compro->logo;
        $this->about = $compro->about;
        $this->address = $compro->address;
        $this->phone = $compro->phone;
        $this->email = $compro->email;
        $this->privacy_policy = $compro->privacy_policy;
        $this->privacy_policy_updated_at = $compro->privacy_policy_updated_at;
        $this->terms_and_conditions = $compro->terms_and_conditions;
        $this->terms_and_conditions_updated_at = $compro->terms_and_conditions_updated_at;
        $this->url_maps = $compro->url_maps;
        $this->url_facebook = $compro->url_facebook;
        $this->url_instagram = $compro->url_instagram;
        $this->url_linkedin = $compro->url_linkedin;
        $this->url_youtube = $compro->url_youtube;
        $this->url_tiktok = $compro->url_tiktok;
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nama Perusahaan')
                ->required()
                ->maxLength(255)
                ->disabled($this->isReadonly)
                ->default($this->name),

            Forms\Components\FileUpload::make('logo')
                ->directory('company')
                ->maxSize(5120)
                ->image()
                ->disabled($this->isReadonly)
                ->default($this->logo),

            Forms\Components\TextInput::make('address')
                ->label('Alamat')
                ->required()
                ->maxLength(255)
                ->disabled($this->isReadonly)
                ->default($this->address),

            Forms\Components\TextInput::make('phone')
                ->label('Telepon')
                ->required()
                ->rule('regex:/^08[0-9]{8,11}$/')
                ->helperText('Nomor harus dimulai dengan 08 dan memiliki 10-13 digit.')
                ->disabled($this->isReadonly)
                ->default($this->phone),

            Forms\Components\TextInput::make('email')
                ->label('E-mail')
                ->email()
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->email),

            Forms\Components\RichEditor::make('about')
                ->label('Tentang')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->about),

            Forms\Components\DatePicker::make('privacy_policy_updated_at')
                ->label('Tanggal Perubahan Kebijakan Privasi')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->privacy_policy_updated_at),

            Forms\Components\RichEditor::make('privacy_policy')
                ->label('Kebijakan Privasi')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->about),

            Forms\Components\DatePicker::make('terms_and_conditions_updated_at')
                ->label('Tanggal Perubahan Syarat & Ketentuan')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->terms_and_conditions_updated_at),

            Forms\Components\RichEditor::make('terms_and_conditions')
                ->label('Syarat & Ketentuan')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->about),

            Forms\Components\TextInput::make('url_maps')
                ->label('URL Maps')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->url_maps),

            Forms\Components\TextInput::make('url_facebook')
                ->label('URL Facebook')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->url_facebook),

            Forms\Components\TextInput::make('url_instagram')
                ->label('URL Instagram')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->url_instagram),

            Forms\Components\TextInput::make('url_linkedin')
                ->label('URL LinkedIn')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->url_linkedin),

            Forms\Components\TextInput::make('url_youtube')
                ->label('URL YouTube')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->url_youtube),

            Forms\Components\TextInput::make('url_tiktok')
                ->label('URL TikTok')
                ->required()
                ->disabled($this->isReadonly)
                ->default($this->url_tiktok),

            Forms\Components\TextInput::make('password')
                ->password()
                ->label('Konfirmasi Kata Sandi')
                ->helperText('Masukkan kata sandi untuk konfirmasi perubahan.')
                ->hidden(fn() => $this->isReadonly)
                ->required(fn() => !$this->isReadonly)
                ->rule(function () {
                    return function ($attribute, $value, $fail) {
                        if (!Hash::check($value, Auth::user()->password)) {
                            $fail('Kata sandi tidak valid.');
                        }
                    };
                }),
        ];
    }

    public function submit()
    {
        if ($this->isReadonly) {
            abort(403, 'Unauthorized action');
        }

        $data = $this->validate([
            'name' => 'required|max:255',
            'phone' => 'required|regex:/^08[0-9]{8,11}$/',
            'email' => 'required|email',
            'password' => 'required',
            'address' => 'required|max:255',
            'logo' => 'image|max:5120',
            'about' => 'required',
            'privacy_policy_updated_at' => 'date',
            'privacy_policy' => 'required',
            'terms_and_conditions_updated_at' => 'date',
            'terms_and_conditions' => 'required',
            'url_maps' => 'max:255',
            'url_facebook' => 'max:255',
            'url_instagram' => 'max:255',
            'url_linkedin' => 'max:255',
            'url_youtube' => 'max:255',
            'url_tiktok' => 'max:255',
        ]);

        if (!Hash::check($data['password'], Auth::user()->password)) {
            Notification::make()
                ->title('Kata sandi tidak valid')
                ->danger()
                ->send();
            return;
        }

        $compro = Compro::firstOrNew();
        $compro->fill(collect($data)->except('password')->toArray());

        if (isset($data['logo']) && $data['logo'] !== $this->logo) {
            $compro->logo = $data['logo'];
        }

        $compro->save();

        Notification::make()
            ->title('Data perusahaan berhasil diperbarui')
            ->success()
            ->send();
    }
}
