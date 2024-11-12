<?php

namespace App\Filament\Resources;

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
use App\Filament\Resources\PropertyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PropertyResource\RelationManagers;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationLabel = 'Daftar Property';

    protected static ?string $navigationGroup = 'Properties';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Property')
                    ->columns(['default' => 1, 'md' => 2])
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Code')
                            ->readOnly()
                            ->maxLength(255)
                            ->visible(fn ($record) => $record ? true : false),
                        Forms\Components\TextInput::make('title')    
                            ->label('Judul')
                            ->autofocus()
                            ->required()
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
                                'Kantor' => 'Kantor',
                                'Tanah' => 'Tanah',
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
                            ->searchable()
                            ->required()
                            ->options(Province::all()->pluck('name', 'id'))
                            ->reactive()
                            ->default(fn ($state) => $state['provinces_id'] ?? null)
                            ->afterStateUpdated(fn (callable $set) => $set('regencies_id', null)),
                        Forms\Components\Select::make('regencies_id')
                            ->label('Kota/Kabupaten')
                            ->searchable()
                            ->required()
                            ->options(function (callable $get) {
                                $provinceId = $get('provinces_id');
                                return $provinceId ? Regency::where('province_id', $provinceId)->pluck('name', 'id') : [];
                            })
                            ->reactive()
                            ->default(fn ($state) => $state['regencies_id'] ?? null)
                            ->afterStateUpdated(fn (callable $set) => $set('districts_id', null)),
            
                        Forms\Components\Select::make('districts_id')
                            ->label('Kecamatan')
                            ->searchable()
                            ->required()
                            ->options(function (callable $get) {
                                $regencyId = $get('regencies_id');
                                return $regencyId ? District::where('regency_id', $regencyId)->pluck('name', 'id') : [];
                            })
                            ->reactive()
                            ->default(fn ($state) => $state['districts_id'] ?? null)
                            ->afterStateUpdated(fn (callable $set) => $set('villages_id', null)),
            
                        Forms\Components\Select::make('villages_id')
                            ->label('Kelurahan/Desa')
                            ->searchable()
                            ->required()
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
                            ->label('Legalitas Surat')
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

                Forms\Components\Section::make('Informasi Lanjutan')
                    ->columns(['default' => 1, 'md' => 2])
                    ->schema([
                        Forms\Components\Select::make('posted_by')
                        ->columnSpan('full')
                        ->options(User::pluck('name', 'id'))
                        ->disabled(),
                        Forms\Components\TextInput::make('url_map')
                        ->columnSpan('full')
                        ->label('Link Map (embed)')
                        ->nullable()
                        ->maxLength(255),
                        Forms\Components\Toggle::make('active')
                            ->required(),
                        Forms\Components\Toggle::make('promoted')
                            ->required(),
                        Forms\Components\Toggle::make('premium')
                            ->required(), 
                        Forms\Components\Toggle::make('sold')
                            ->required()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Set sold_by dan sold_at menjadi required jika sold true
                                if ($state) {
                                    $set('sold_by', null); // Kosongkan field jika sold menjadi true
                                    $set('sold_at', null);  // Kosongkan field jika sold menjadi true
                                }
                            }),
                        Forms\Components\Select::make('sold_by')
                            ->options(User::where('role', 'Admin')->orwhere('role', 'Agent')->orwhere('role', 'Super Admin')->pluck('name', 'id'))
                            ->searchable()
                            ->required(fn ($get) => $get('sold') === true), // Kondisi untuk required
                        Forms\Components\DateTimePicker::make('sold_at')
                            ->required(fn ($get) => $get('sold') === true), // Kondisi untuk required
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\TextColumn::make('url_map')
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
                    ->suffix(' m2')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('luas_bangunan')
                    ->numeric()
                    ->suffix(' m2')
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
                    ->suffix(' watt')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sertifikat')
                    ->label('Legalitas Surat')
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
                Tables\Columns\ToggleColumn::make('active')
                    ->sortable(),
                Tables\Columns\IconColumn::make('sold')
                    ->sortable()
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sold_at')
                    ->dateTime()
                    ->sortable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('seller.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('promoted')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('premium')
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
                Tables\Filters\TrashedFilter::make()
                ->hidden(Auth::user()->role !== 'superadmin'), //Hanya bisa dilihat oleh superadmin
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
                Tables\Actions\ForceDeleteAction::make()
                ->hidden(Auth::user()->role !== 'superadmin'),
                Tables\Actions\RestoreAction::make()
                ->hidden(Auth::user()->role !== 'superadmin'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),         
                    Tables\Actions\ForceDeleteBulkAction::make()
                    ->hidden(Auth::user()->role !== 'superadmin'),
                    Tables\Actions\RestoreBulkAction::make()
                    ->hidden(Auth::user()->role !== 'superadmin'),
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
}
