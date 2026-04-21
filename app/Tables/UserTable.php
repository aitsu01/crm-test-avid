<?php

namespace App\Tables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ingenia\Avid\Enums\Color;
use Ingenia\Avid\Tables\Actions\Action;
use Ingenia\Avid\Tables\Actions\ActionGroup;
use Ingenia\Avid\Tables\Columns\Column;
use Ingenia\Avid\Tables\Columns\TextColumn;
use Ingenia\Avid\Tables\Filters\Filter;
use Ingenia\Avid\Tables\Table;

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
        ];
    }

    public function getFilters(): array
    {
        return [];
    }

    public function getBulkActions(): array
    {
        return [
            Action::make('create', 'Nuovo')
                ->icon('pi pi-plus')
                ->url(avidRoute('users.create'))
                ->showLabel(),
        ];
    }

    public function getActions(): array
    {
        return [
            Action::make('edit', 'Modifica')
                ->icon('pi pi-pen-to-square')
                ->color(Color::Warning)
                ->url(fn (Model $record) => avidRoute('users.edit', $record)),

            Action::make('delete', 'Elimina')
                ->icon('pi pi-trash')
                ->post()
                ->color(Color::Danger)
                ->requiresConfirmation()
                ->delete()
                ->url(fn (Model $record) => avidRoute('users.destroy', $record)),
        ];
    }

    public function getRecordUrl(Model $record): ?string
    {
        return avidRoute('users.edit', $record);
    }
}