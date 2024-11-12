<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Testimony;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TestimonyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TestimonyResource\RelationManagers;

class TestimonyResource extends Resource
{
    protected static ?string $model = Testimony::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationLabel = 'Daftar Testimoni';

    protected static ?string $navigationGroup = 'Testimoni';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Testimonial')
                    ->schema([
                        Forms\Components\TextInput::make('client')
                            ->label('Nama Client')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image')
                            ->label('Foto Client')
                            ->directory('testimoni')
                            ->imageEditor()
                            ->maxSize(5120)
                            ->imageEditorAspectRatios([
                                '1:1',
                            ])
                            ->image(),
                        Forms\Components\TagsInput::make('category')
                            ->label('Kategori')
                            ->required()
                            ->helperText('Gunakan Tab atau Enter untuk memilih kategori')
                            ->suggestions([
                                'Bangun Baru'=>'Bangun Baru',
                                'Interior'=>'Interior',
                                'Exterior'=>'Exterior',
                                'Renovasi'=>'Renovasi',
                                'Furniture'=>'Furniture',
                                'Jual Rumah'=>'Jual Rumah',
                                'Beli Rumah'=>'Beli Rumah',
                            ]),
                        Forms\Components\Textarea::make('testimony')
                            ->label('Testimoni')
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
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('client')
                    ->searchable(),
                Tables\Columns\TextColumn::make('testimony')
                    ->searchable(),
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
            'index' => Pages\ListTestimonies::route('/'),
            'create' => Pages\CreateTestimony::route('/create'),
            'edit' => Pages\EditTestimony::route('/{record}/edit'),
        ];
    }
}
