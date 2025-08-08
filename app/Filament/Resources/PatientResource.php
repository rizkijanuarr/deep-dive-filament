<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\RelationManagers\TreatmentsRelationManager;
use App\Filament\Resources\PatientResource\Pages;
use App\Models\Patient;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\GlobalSearch\Actions\Action;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // registered global search
    protected static ?string $recordTitleAttribute = 'name';

    // function for as global search
    public static function getGlobalSearchResultTitle(\Illuminate\Database\Eloquent\Model $record): string|\Illuminate\Contracts\Support\Htmlable
    {
        return $record->name;
    }

    // search hardcore
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'type', 'owner.name'];
    }

    // Lazy Load search
    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'Owner' => $record->owner->name,
            'Pet Type' => $record->type
        ];
    }

    // Eager Load search | be better performance
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['owner']);
    }

    // custom redirect to details from global search
    public static function getGlobalSearchResultUrl(\Illuminate\Database\Eloquent\Model $record): string
    {
        return PatientResource::getUrl('view', ['record' => $record]);
    }

    // custom button from global search
    public static function getGlobalSearchResultActions(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            Action::make('Details')
                ->button()
                ->url(static::getUrl('view', ['record' => $record]), shouldOpenInNewTab: true),
            Action::make('Edit')
                ->button()
                ->url(static::getUrl('edit', ['record' => $record]), shouldOpenInNewTab: true),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::getNameFormField(),
                static::getDOBFormField(),
                static::getTypeFormField(),
                static::getOwnerFormField(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('owner.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'cat' => 'Cat',
                        'dog' => 'Dog',
                        'rabbit' => 'Rabbit',
                    ]),
                SelectFilter::make('owner')
                    ->relationship('owner', 'name'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TreatmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
            'view' => Pages\ViewPatient::route('/{record}'),
        ];
    }

    public static function getNameFormField(): Forms\Components\TextInput
    {
        return TextInput::make('name')
            ->required()
            ->maxLength(255);
    }

    public static function getDOBFormField(): Forms\Components\DatePicker
    {
        return DatePicker::make('date_of_birth')
            ->required()
            ->maxDate(now());
    }

    public static function getTypeFormField(): Forms\Components\Select
    {
        return Select::make('type')
            ->options([
                'cat' => 'Cat',
                'dog' => 'Dog',
                'rabbit' => 'Rabbit',
            ])
            ->required();
    }

    public static function getOwnerFormField(): Forms\Components\Select
    {
        return Select::make('owner_id')
            ->relationship('owner', 'name')
            ->searchable()
            ->preload()
            ->createOptionForm([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Phone number')
                    ->tel()
                    ->required(),
            ])
            ->required();
    }
}
