<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Portfolio;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PortfolioResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PortfolioResource\RelationManagers;
use Illuminate\Support\Facades\Auth;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Daftar Portfolio';

    protected static ?string $navigationGroup = 'Portfolios';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Portfolio')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->autofocus()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image')
                            ->label('Gambar')
                            ->directory('portfolio')
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
                            ->image(),
                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->multiple()
                            ->required()
                            ->options([
                                'Bangun Baru'=>'Bangun Baru',
                                'Renovasi'=>'Renovasi',
                                'Furniture'=>'Furniture',
                                'Interior' => 'Interior',
                                'Exterior' => 'Exterior',
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->autosize()
                            ->required()
                            ->maxLength(255),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->limit(50),
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
                Tables\Filters\SelectFilter::make('category')
                    ->multiple()
                    ->options([
                        'Bangun Baru'=>'Bangun Baru',
                        'Renovasi'=>'Renovasi',
                        'Furniture'=>'Furniture',
                        'Interior' => 'Interior',
                        'Exterior' => 'Exterior',
                    ])
                    ->query(function ($query, array $data) {
                        return $query->where(function ($q) use ($data) {
                            foreach ($data as $category) {
                                $q->orWhereJsonContains('category', $category);
                            }
                        });
                    })
                    ->label('Category'),
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
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}
