<?php

namespace App\Tables;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ingenia\Avid\Enums\Color;
use Ingenia\Avid\Tables\Actions\Action;
use Ingenia\Avid\Tables\Columns\TextColumn;
use Ingenia\Avid\Tables\Filters\DateFilter;
use Ingenia\Avid\Tables\Filters\SelectFilter;
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

            TextColumn::make('status', 'Stato')
                ->sortable()
                ->searchable(),

            TextColumn::make('priority', 'Priorità')
                ->sortable()
                ->searchable(),

            TextColumn::make('due_date', 'Scadenza')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y') : ''),

            TextColumn::make('created_at', 'Creata il')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y H:i') : ''),

            TextColumn::make('updated_at', 'Modificata il')
                ->sortable()
                ->searchable()
                ->formatStateUsing(fn ($state) => $state ? Carbon::parse($state)->format('d/m/Y H:i') : ''),

            TextColumn::make('description', 'Descrizione')
                ->sortable()
                ->searchable(),
        ];
    }

    public function getFilters(): array
    {
        return [
            SelectFilter::make('project_id')
                ->label('Progetto')
                ->options(
                    Project::query()
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->toArray()
                ),

            SelectFilter::make('status')
                ->label('Stato')
                ->options([
                    'todo' => 'Da fare',
                    'in_progress' => 'In corso',
                    'done' => 'Completata',
                ]),

            SelectFilter::make('priority')
                ->label('Priorità')
                ->options([
                    'low' => 'Bassa',
                    'medium' => 'Media',
                    'high' => 'Alta',
                ]),

            DateFilter::make('due_date')
                ->label('Scadenza'),
        ];
    }

    public function getBulkActions(): array
    {
        return [
            Action::make('create', 'Nuovo')
                ->icon('pi pi-plus')
                ->url(avidRoute('tasks.create'))
                ->openUrlInModal(true, 'md')
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
                ->url(fn (Model $record) => avidRoute('tasks.edit', $record))
                ->openUrlInModal(true, 'md'),

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
        return null;
    }

    public function defaultSort(): ?array
    {
        return ['due_date' => 'asc'];
    }

    

    

    
}