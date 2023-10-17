<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Role;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\RoleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RoleResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->minLength(3)
                    ->maxLength(25),
                CheckboxList::make('permissions')
                    ->relationship('permissions','name')
                    ->columns(4)
                    ->bulkToggleable()
                    ->searchable()
                    ->noSearchResultsMessage('No Permissions found.'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make()
                    ->label('How to Display Records?')
                    ->visible(auth()->user()->canViewTrashed())
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([ //ActionGroup to group all the actions
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()->successNotificationTitle('Role Deleted Successfully'),
                    Tables\Actions\ForceDeleteAction::make()->successNotificationTitle('Role Deleted Permanently'),
                    Tables\Actions\RestoreAction::make()->successNotificationTitle('Role Restored Successfully'),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([ //BulkActionGroup to group all the actions
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
                ExportBulkAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('name','!=','Admin');
    }

}
