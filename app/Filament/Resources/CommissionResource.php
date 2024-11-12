<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommissionResource\Pages;
use App\Filament\Resources\CommissionResource\RelationManagers;
use App\Models\Commission;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommissionResource extends Resource
{
    protected static ?string $model = Commission::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Commission';

    protected static ?string $navigationGroup = 'Properties';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('property_id')
                    ->label('Kode Property')
                    ->columnSpan('full')
                    ->options(Property::where('sold', true)->whereNotIn('id', Commission::pluck('property_id'))->pluck('code', 'id'))
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        // Mengambil property yang dipilih
                        $property = Property::find($state);
                        if ($property) {
                            // Mengisi posted_by dengan user yang memposting property
                            $set('posted_by', $property->posted_by);
                            // Mengisi sold_by dengan user yang menjual property
                            $set('sold_by', $property->sold_by);
                        }
                    })
                    ->reactive(),
                Forms\Components\TextInput::make('deal_price')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('company_commission')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('posted_by')
                    ->label('Posted By')
                    ->relationship('listerCommission', 'name') // Mengambil nama pengguna yang memposting
                    ->disabled() // Menjadikan field ini readonly
                    ->default(fn ($get) => Property::find($get('property_id'))?->posted_by)
                    ->required()
                    ->reactive()
                    ->dehydrated(true),
                Forms\Components\TextInput::make('listing_commission')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('sold_by')
                    ->label('Sold By')
                    ->relationship('sellerCommission', 'name') // Mengambil nama pengguna yang menjual
                    ->disabled() // Menjadikan field ini readonly
                    ->default(fn ($get) => Property::find($get('property_id'))?->sold_by)
                    ->required()    
                    ->reactive()
                    ->dehydrated(true),
                Forms\Components\TextInput::make('selling_commission')
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('pembayaran')
                    ->label('Bukti Pembayaran Komisi')
                    ->directory('commission')
                    ->columnSpan('full')
                    ->multiple()
                    ->maxSize(5120)
                    ->reorderable()
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('property.code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deal_price')
                    ->money('idr', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('company_commission')
                    ->money('idr', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('listerCommission.name')
                    ->label('Posted By')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('listing_commission')
                    ->money('idr', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('sellerCommission.name')
                    ->label('Sold By')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('selling_commission')
                    ->money('idr', true)
                    ->sortable(),
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
                //
            ])
            ->actions([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommissions::route('/'),
            'create' => Pages\CreateCommission::route('/create'),
            'edit' => Pages\EditCommission::route('/{record}/edit'),
        ];
    }
}
