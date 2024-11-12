<?php

namespace App\Filament\User\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Property;
use App\Models\Province;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\User\Resources\PropertyResource\Pages;
use App\Filament\User\Resources\PropertyResource\RelationManagers;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationLabel = 'Daftar Property Anda';

    protected static ?string $navigationGroup = 'Properties';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Property')
                    ->columns(['default' => 1, 'md' => 2])
                    ->schema([
                        Forms\Components\TextInput::make('title')    
                            ->label('Judul')
                            ->autofocus()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('code')
                            ->label('Code')
                            ->hint('Abaikan, akan diisi otomatis')
                            ->readOnly()
                            ->maxLength(255),
                        Forms\Components\Select::make('type')
                            ->label('Jual/Sewa')
                            ->required()
                            ->options([
                                'Jual' => 'Jual',
                                'Sewa' => 'Sewa',
                            ]),
                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->required()
                            ->options([
                                'Rumah' => 'Rumah',
                                'Apartement' => 'Apartement',
                                'Villa' => 'Villa',
                            ]),
                        Forms\Components\FileUpload::make('image')
                            ->columnSpan('full')
                            ->label('Gambar')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->multiple()
                            ->maxSize(5120)
                            ->reorderable()
                            ->directory('property')
                            ->image(),
                    ]),

                Forms\Components\Section::make('Informasi Alamat')
                    ->schema([
                        Forms\Components\Select::make('provinces_id')
                            ->label('Provinsi')
                            ->required()
                            ->searchable()
                            ->options(Province::all()->pluck('name', 'id'))
                            ->reactive()
                            ->default(fn ($state) => $state['provinces_id'] ?? null)
                            ->afterStateUpdated(fn (callable $set) => $set('regencies_id', null)),
                        Forms\Components\Select::make('regencies_id')
                            ->label('Kota/Kabupaten')
                            ->required()
                            ->searchable()
                            ->options(function (callable $get) {
                                $provinceId = $get('provinces_id');
                                return $provinceId ? Regency::where('province_id', $provinceId)->pluck('name', 'id') : [];
                            })
                            ->reactive()
                            ->default(fn ($state) => $state['regencies_id'] ?? null)
                            ->afterStateUpdated(fn (callable $set) => $set('districts_id', null)),
            
                        Forms\Components\Select::make('districts_id')
                            ->label('Kecamatan')
                            ->required()
                            ->searchable()
                            ->options(function (callable $get) {
                                $regencyId = $get('regencies_id');
                                return $regencyId ? District::where('regency_id', $regencyId)->pluck('name', 'id') : [];
                            })
                            ->reactive()
                            ->default(fn ($state) => $state['districts_id'] ?? null)
                            ->afterStateUpdated(fn (callable $set) => $set('villages_id', null)),
            
                        Forms\Components\Select::make('villages_id')
                            ->label('Kelurahan/Desa')
                            ->required()
                            ->searchable()
                            ->options(function (callable $get) {
                                $districtId = $get('districts_id');
                                return $districtId ? Village::where('district_id', $districtId)->pluck('name', 'id') : [];
                            })
                            ->reactive()
                            ->default(fn ($state) => $state['villages_id'] ?? null),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->autosize()
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Detail Property')
                    ->columns(['default' => 1, 'md' => 2])
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->columnSpan('full')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp. '),
                        Forms\Components\TextInput::make('luas_tanah')
                            ->label('Luas Tanah')
                            ->required()
                            ->numeric()
                            ->suffix(' m2'),
                        Forms\Components\TextInput::make('luas_bangunan')
                            ->label('Luas Bangunan')
                            ->required()
                            ->numeric()
                            ->suffix(' m2'),
                        Forms\Components\TextInput::make('kamar_tidur')
                            ->label('Jumlah Kamar Tidur')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('kamar_mandi')
                            ->label('Jumlah Kamar Mandi')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('jumlah_lantai')
                            ->label('Jumlah Lantai')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('carport')
                            ->label('Jumlah Carport')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('listrik')
                            ->label('Listrik')
                            ->suffix(' watt')
                            ->required()
                            ->numeric(),
                        Forms\Components\Select::make('sertifikat')
                            ->label('Sertifikat')
                            ->required()
                            ->options([
                                'SHM' => 'SHM',
                                'SHGB' => 'SHGB',
                                'AJB' => 'AJB',
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->columnSpan('full')
                            ->label('Deskripsi')
                            ->required()
                            ->autosize()
                            ->maxLength(255),
                        Forms\Components\TagsInput::make('amenities')
                            ->columnSpan('full')
                            ->label('Fasilitas Rumah')
                            ->helperText('Gunakan Tab atau Enter untuk memilih')
                            ->suggestions([
                                'Kolam Renang' => 'Kolam Renang',
                                'Pusat Kebugaran (Gym)' => 'Pusat Kebugaran (Gym)',
                                'AC (Air Conditioning)' => 'AC (Air Conditioning)',
                                'Fully Furnished' => 'Fully Furnished',
                                'Dapur' => 'Dapur',
                                'Balkon' => 'Balkon',
                                'Wi-Fi / Internet' => 'Wi-Fi / Internet',
                                'Ruang Laundry' => 'Ruang Laundry',
                                'Tempat Parkir' => 'Tempat Parkir',
                                'Sistem Keamanan' => 'Sistem Keamanan',
                                'Lift' => 'Lift',
                                'Bathtub' => 'Bathtub',
                                'Lemari Pakaian' => 'Lemari Pakaian',
                                'Pemanas Air' => 'Pemanas Air',
                                'Sistem Rumah Pintar' => 'Sistem Rumah Pintar',
                            ]),                
                        Forms\Components\TagsInput::make('features')
                            ->columnSpan('full')
                            ->label('Fasilitas Lingkungan')
                            ->helperText('Gunakan Tab atau Enter untuk memilih')
                            ->suggestions([
                                'Dekat Sekolah' => 'Dekat Sekolah',
                                'Dekat Rumah Sakit' => 'Dekat Rumah Sakit',
                                'Dekat Pusat Perbelanjaan' => 'Dekat Pusat Perbelanjaan',
                                'Akses Transportasi Umum' => 'Akses Transportasi Umum',
                                'Taman atau Area Hijau' => 'Taman atau Area Hijau',
                                'Area Bermain Anak' => 'Area Bermain Anak',
                                'Fasilitas Olahraga (Lapangan)' => 'Fasilitas Olahraga (Lapangan)',
                                'Pusat Komunitas' => 'Pusat Komunitas',
                                'Dekat Restoran atau Kafe' => 'Dekat Restoran atau Kafe',
                                'Keamanan 24 Jam' => 'Keamanan 24 Jam',
                                'Lahan Parkir Luas' => 'Lahan Parkir Luas',
                                'Fasilitas Pengisian Kendaraan Listrik' => 'Fasilitas Pengisian Kendaraan Listrik',
                            ]),
                    ]),

                Forms\Components\Section::make('Informasi Pemilik')
                    ->schema([
                        Forms\Components\TextInput::make('owner_name')
                            ->label('Nama Pemilik')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('owner_phone')
                            ->label('Nomor Telepon Pemilik')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('owner_email')
                            ->label('Email Pemilik')
                            ->email()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Property::where('posted_by', Auth::id())) // Filter by logged-in user
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->square()
                    ->size(40)
                    ->stacked(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('province.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('regency.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('district.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('village.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('idr', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('luas_tanah')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_bangunan')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('jumlah_lantai')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kamar_tidur')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kamar_mandi')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('carport')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('listrik')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sertifikat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('owner_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('owner_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('lister.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('sold')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('promoted')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('premium')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis Properti')
                    ->options([
                        'Jual' => 'Jual',
                        'Sewa' => 'Sewa',
                    ]),

                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Rumah' => 'Rumah',
                        'Apartement' => 'Apartement',
                        'Villa' => 'Villa',
                        'Kantor' => 'Kantor',
                        'Tanah' => 'Tanah',
                    ]),

                Tables\Filters\Filter::make('active_true')
                    ->label('Aktif')
                    ->query(fn (Builder $query) => $query->where('active', true)),

                Tables\Filters\Filter::make('active_false')
                    ->label('Tidak Aktif')
                    ->query(fn (Builder $query) => $query->where('active', false)),

                Tables\Filters\Filter::make('sold_true')
                    ->label('Terjual')
                    ->query(fn (Builder $query) => $query->where('sold', true)),

                Tables\Filters\Filter::make('sold_false')
                    ->label('Belum Terjual')
                    ->query(fn (Builder $query) => $query->where('sold', false)),

                Tables\Filters\Filter::make('price_range')
                    ->label('Rentang Harga')
                    ->form([
                        Forms\Components\TextInput::make('min_price')
                            ->numeric()
                            ->placeholder('Harga Minimum'),
                        Forms\Components\TextInput::make('max_price')
                            ->numeric()
                            ->placeholder('Harga Maksimum'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['min_price'], fn ($q) => $q->where('price', '>=', $data['min_price']))
                            ->when($data['max_price'], fn ($q) => $q->where('price', '<=', $data['max_price']));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }

    protected static function afterCreate($record)
    {
        // Mendapatkan semua admin dan superadmin
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();

        // Mendapatkan pengguna yang sedang login
        $currentUser = Auth::user();

        // Mengirim notifikasi ke masing-masing admin dan superadmin
        foreach ($admins as $admin) {
            Notification::make()
                ->title('New Portfolio Added')
                ->body('A new portfolio has been added by ' . $currentUser->name)
                ->url('/admin/portfolios/' . $record->slug) // URL tujuan saat notifikasi diklik
                ->sendToDatabase($admin);
        }
    }

    protected static function afterUpdate($record)
    {
        // Mendapatkan semua admin dan superadmin
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();

        // Mendapatkan pengguna yang sedang login
        $currentUser = Auth::user();

        // Memastikan pengguna yang sedang login tidak null
        if ($currentUser) {
            // Mengirim notifikasi ke masing-masing admin dan superadmin
            foreach ($admins as $admin) {
                Notification::make()
                    ->title('Portfolio Updated')
                    ->body('The portfolio titled "' . $record->title . '" has been updated by ' . $currentUser->name)
                    ->url('/admin/portfolios/' . $record->slug) // URL tujuan saat notifikasi diklik
                    ->sendToDatabase($admin);
            }
        }
    }
}
