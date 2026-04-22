<?php

namespace App\Tables;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ingenia\Avid\Enums\Color;
use Ingenia\Avid\Tables\Actions\Action;
use Ingenia\Avid\Tables\Actions\ActionGroup;
use Ingenia\Avid\Tables\Columns\TextColumn;
use Ingenia\Avid\Tables\Table;

class TaskTable extends Table
{
    public function getQuery(): Builder
    {
        return Task::query()->with('project');
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

            TextColumn::make('project.name', 'Progetto')
                ->sortable()
                ->searchable(),

            TextColumn::make('description', 'Descrizione')
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
                ->url(avidRoute('tasks.create'))
                ->showLabel(),

            Action::make('delete', 'Elimina selezionati')
                ->icon('pi pi-trash')
                ->color(Color::Danger)
                ->requiresConfirmation()
                ->showLabel()
                ->delete()
                ->url(avidRoute('tasks.bulk.destroy')),
        ];
    }

    public function getActions(): array
    {
        return [
            Action::make('edit', 'Modifica')
                ->icon('pi pi-pen-to-square')
                ->color(Color::Warning)
                ->url(fn (Model $record) => avidRoute('tasks.edit', $record)),

            Action::make('delete', 'Elimina')
                ->icon('pi pi-trash')
                ->color(Color::Danger)
                ->requiresConfirmation()
                ->delete()
                ->url(fn (Model $record) => avidRoute('tasks.destroy', $record)),
        ];
    }

    public function getRecordUrl(Model $record): ?string
    {
        return avidRoute('tasks.edit', $record);
    }
}