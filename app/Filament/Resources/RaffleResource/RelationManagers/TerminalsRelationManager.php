<?php

namespace App\Filament\Resources\RaffleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\{Form, Table};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class TerminalsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'terminals';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                TextInput::make('number')
                    ->rules(['required', 'numeric'])
                    ->numeric()
                    ->placeholder('Number')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('price')
                    ->rules(['required', 'numeric'])
                    ->numeric()
                    ->placeholder('Price')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Select::make('status')
                    ->rules(['required', 'in:available,saved,unavailable'])
                    ->searchable()
                    ->options([
                        'available' => 'Available',
                        'saved' => 'Saved',
                        'unavailable' => 'Unavailable',
                    ])
                    ->placeholder('Status')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                BelongsToSelect::make('ticket_id')
                    ->rules(['nullable', 'exists:tickets,id'])
                    ->relationship('ticket', 'id')
                    ->searchable()
                    ->placeholder('Ticket')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('raffle.name')->limit(50),
                Tables\Columns\TextColumn::make('number'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('status')->enum([
                    'available' => 'Available',
                    'saved' => 'Saved',
                    'unavailable' => 'Unavailable',
                ]),
                Tables\Columns\TextColumn::make('ticket.id')->limit(50),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                    $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('raffle_id')->relationship(
                    'raffle',
                    'name'
                ),

                MultiSelectFilter::make('ticket_id')->relationship(
                    'ticket',
                    'id'
                ),
            ]);
    }
}
