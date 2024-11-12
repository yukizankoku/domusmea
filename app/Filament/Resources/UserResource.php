<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Daftar User';

    protected static ?string $navigationGroup = 'Configuration';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('avatar')
                    ->label('Profile Picture')
                    ->disabled(Auth::user()->role !== 'superadmin')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                    ])
                    ->maxSize(5120)
                    ->directory('profile'),
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->autofocus()
                    ->readOnly(Auth::user()->role !== 'superadmin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('username')
                    ->label('Username')
                    ->readOnly(Auth::user()->role !== 'superadmin')
                    ->required()
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->readOnly(Auth::user()->role !== 'superadmin')
                    ->email()
                    ->unique()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('No. Hp') 
                    ->readOnly(Auth::user()->role !== 'superadmin')
                    ->tel()
                    ->required()
                    ->unique()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->label('Role')
                    ->required()
                    ->default('User')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                        'superadmin' => 'Super Admin',
                        'agent' => 'Agent',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Profile Picture')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('role')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
