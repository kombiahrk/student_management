<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use App\Models\Course;
use App\Models\Student;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;
use Filament\Infolists\Components\Section as ComponentsSection;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Student Management';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() < 10 ? 'warning' : 'gray';
    }

    protected static ?string $recordTitleAttribute = 'first_name';

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return 'Student Name = '.$record->first_name." ".$record->last_name;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name','last_name','middle_name', 'city.name','pincode'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Course ' => $record->course->name,
            'City ' => $record->city->name,
            'Date of Joining ' => date('d/m/Y', strtotime($record->date_of_joining))
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['course','city']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Student Meta')
                    ->schema([
                        Forms\Components\Select::make('country_id')
                            ->relationship(name:'country', titleAttribute:'name')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('state_id', null);
                                $set('city_id', null);
                            })
                            ->native(false),
                        Forms\Components\Select::make('state_id')
                            ->options(fn (Get $get): Collection => State::query()
                                ->where('country_id', $get('country_id'))
                                ->pluck('name','id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('city_id', null))
                            ->native(false),
                        Forms\Components\Select::make('city_id')
                            ->options(fn (Get $get): Collection => City::query()
                                ->where('state_id', $get('state_id'))
                                ->pluck('name','id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->native(false),
                        Forms\Components\Select::make('course_id')
                            ->relationship(name:'course', titleAttribute:'name')
                            ->required()
                            ->native(false),
                    ])->columns(2),
                Section::make('Student Name')
                    ->description('Fill the Name Details')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('middle_name')
                            ->maxLength(255),
                    ])->columns(3),
                Section::make('Student Address')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('pincode')
                            ->required()
                            ->numeric()
                            ->maxLength(6),
                    ])->columns(2),
                Section::make('Dates')
                    ->schema([
                        Forms\Components\DatePicker::make('date_of_birth')
                            // ->native(false)
                            ->displayFormat('d/m/Y')
                            ->required(),
                        Forms\Components\DatePicker::make('date_of_joining')
                            // ->native(false)
                            ->displayFormat('d/m/Y')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('city.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pincode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_of_joining')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('date_of_joining','desc')
            ->filters([
                SelectFilter::make('Course')
                    ->relationship('course','name')
                    ->label('Filter by course')
                    ->indicator('Course'),
                Filter::make('joined_at')
                    ->form([
                        DatePicker::make('joined_from'),
                        DatePicker::make('joined_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['joined_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date_of_joining', '>=', $date),
                            )
                            ->when(
                                $data['joined_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date_of_joining', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['joined_from'] ?? null) {
                            $indicators['joined_from'] = 'Joined from ' . Carbon::parse($data['joined_from'])->toFormattedDateString();
                        }

                        if ($data['joined_until'] ?? null) {
                            $indicators['joined_until'] = 'Joined until ' . Carbon::parse($data['joined_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    })->columns(2)->columnSpan(2)
                ],layout:FiltersLayout::AboveContentCollapsible)->filtersFormColumns(3)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('Pdf')
                    ->icon('heroicon-o-document')
                    ->color('success')
                    ->url(fn(Student $record)=> route('student.pdf.download',$record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                ComponentsSection::make('Student Meta')->schema([
                    TextEntry::make('country.name'),
                    TextEntry::make('state.name'),
                    TextEntry::make('city.name'),
                    TextEntry::make('course.name'),
                ])->columns(2),
                ComponentsSection::make('Student Name')->schema([
                    TextEntry::make('first_name'),
                    TextEntry::make('middle_name'),
                    TextEntry::make('last_name'),
                ])->columns(3),
                ComponentsSection::make('Student Address')->schema([
                    TextEntry::make('address'),
                    TextEntry::make('pincode'),
                ])->columns(2),
                ComponentsSection::make('Student Dates')->schema([
                    TextEntry::make('date_of_birth')->date('d/m/Y'),
                    TextEntry::make('date_of_joining')->date(),
                ])->columns(2),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            // 'view' => Pages\ViewStudent::route('/{record}'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
