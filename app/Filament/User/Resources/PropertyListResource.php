<?php

namespace App\Filament\User\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Property;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\User\Resources\PropertyListResource\Pages;
use App\Filament\User\Resources\PropertyListResource\RelationManagers;
use Filament\Navigation\NavigationItem;

class PropertyListResource extends Resource
{
    protected static ?string $model = Property::class;
    
    protected static ?string $navigationIcon = 'heroicon-s-home-modern';

    protected static ?string $navigationLabel = 'Daftar Semua Property';

    protected static ?string $navigationGroup = 'Properties';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // pengkondisian untuk property yang aktif dan belum terjual 
            ->query(Property::where('active', true)->where('sold', false))
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
                    ->label('Legalitas Surat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
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
                Action::make('view')
                ->label('View Property')
                ->url(fn (Property $record) => route('property.show', ['property' => $record->code])) // Ganti dengan route yang sesuai
                ->color('primary'),
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationItems(): array
    {
        // Cek apakah user terautentikasi dan memiliki role 'user'
        if (Auth::check() && Auth::user()->role === 'user') {
            return []; // Sembunyikan navigasi untuk user biasa
        }

        return [
            NavigationItem::make('PropertiesList')
                ->label('Daftar Semua Properties')
                ->group('Properties')
                ->url(route('filament.user.resources.property-lists.index'))
                ->icon('heroicon-s-home-modern'), // Ganti dengan icon yang sesuai
        ];
    }

    public static function getPages(): array
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            return []; // Sembunyikan semua halaman untuk user biasa
        }

        return [
            'index' => Pages\ListPropertyLists::route('/'),
        ];
    }
}
