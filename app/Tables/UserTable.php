<?php

namespace App\Tables;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ingenia\Avid\Enums\Color;
use Ingenia\Avid\Tables\Actions\Action;
use Ingenia\Avid\Tables\Actions\ActionGroup;
use Ingenia\Avid\Tables\Columns\TextColumn;
use Ingenia\Avid\Tables\Filters\SelectFilter;
use Ingenia\Avid\Tables\Table;
use App\Enums\UserRole;

class UserTable extends Table
{
    public function getQuery(): Builder
    {
        return User::query();
    }

    public function getColumns(): array
    {
        return [
            TextColumn::make('id', 'ID')
                ->sortable()
                ->searchable()
                ->width('6rem'),

            TextColumn::make('name', 'Nome')
                ->sortable()
                ->searchable(),

            TextColumn::make('email', 'Email')
                ->sortable()
                ->searchable(),

            TextColumn::make('role', 'Ruolo')
                ->sortable()
                ->searchable(),

            TextColumn::make('created_at', 'Creato il')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y H:i') : ''),

            TextColumn::make('updated_at', 'Modificato il')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y H:i') : ''),
        ];
    }

  public function getFilters(): array
{
    return [
        SelectFilter::make('role')
            ->label('Ruolo')
            ->options(UserRole::asOptions()),
    ];
}

    public function getBulkActions(): array
    {
        return [
            Action::make('create', 'Nuovo')
                ->icon('pi pi-plus')
                ->url(avidRoute('users.create'))
                ->openUrlInModal(true, 'md')
                ->showLabel(),

            Action::make('delete', 'Elimina selezionati')
                ->icon('pi pi-trash')
                ->color(Color::Danger)
                ->requiresConfirmation()
                ->showLabel()
                ->delete()
                ->url(avidRoute('users.bulk.destroy')),
        ];
    }

    public function getActions(): array
    {
        return [
            Action::make('edit', 'Modifica')
                ->icon('pi pi-pen-to-square')
                ->color(Color::Warning)
                ->url(fn (Model $record) => avidRoute('users.edit', $record))
                ->openUrlInModal(true, 'md'),

            Action::make('delete', 'Elimina')
                ->icon('pi pi-trash')
                ->color(Color::Danger)
                ->requiresConfirmation()
                ->delete()
                ->url(fn (Model $record) => avidRoute('users.destroy', $record)),
        ];
    }

    public function getRecordUrl(Model $record): ?string
    {
        return null;
    }



    

    public function defaultSort(): ?array
    {
        return ['updated_at' => 'desc'];
    }


}