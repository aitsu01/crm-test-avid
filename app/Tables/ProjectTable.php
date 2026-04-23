<?php

namespace App\Tables;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ingenia\Avid\Enums\Color;
use Ingenia\Avid\Tables\Actions\Action;
use Ingenia\Avid\Tables\Actions\ActionGroup;
use Ingenia\Avid\Tables\Columns\Column;
use Ingenia\Avid\Tables\Columns\TextColumn;
use Ingenia\Avid\Tables\Filters\DateFilter;
use Ingenia\Avid\Tables\Filters\Filter;
use Ingenia\Avid\Tables\Table;

class ProjectTable extends Table
{
    public function getQuery(): Builder
    {
        return Project::query();
    }

    /**
     * @return array<Column>
     */
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

            TextColumn::make('description', 'Descrizione')
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

    /**
     * @return array<Filter>
     */
    public function getFilters(): array
    {
        return [
            DateFilter::make('created_at')
                ->label('Creato il'),

            DateFilter::make('updated_at')
                ->label('Modificato il'),
        ];
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function getBulkActions(): array
    {
        return [
            Action::make('create', 'Nuovo')
                ->icon('pi pi-plus')
                ->url(avidRoute('projects.create'))
                ->openUrlInModal(true, 'md')
                ->showLabel(),

            Action::make('delete', 'Elimina selezionati')
                ->icon('pi pi-trash')
                ->color(Color::Danger)
                ->requiresConfirmation()
                ->showLabel()
                ->delete()
                ->url(avidRoute('projects.bulk.destroy')),
        ];
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function getActions(): array
    {
        return [
            Action::make('edit', 'Modifica')
                ->icon('pi pi-pen-to-square')
                ->color(Color::Warning)
                ->url(fn (Model $record) => avidRoute('projects.edit', $record))
                ->openUrlInModal(true, 'md'),

            Action::make('delete', 'Elimina')
                ->icon('pi pi-trash')
                ->post()
                ->color(Color::Danger)
                ->requiresConfirmation()
                ->delete()
                ->url(fn (Model $record) => avidRoute('projects.destroy', $record)),
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