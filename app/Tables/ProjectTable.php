<?php

namespace App\Tables;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ingenia\Avid\Enums\Color;
use Ingenia\Avid\Tables\Actions\Action;
use Ingenia\Avid\Tables\Actions\ActionGroup;
use Ingenia\Avid\Tables\Columns\Column;
use Ingenia\Avid\Tables\Columns\TextColumn;
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
        ];
    }

    /**
     * @return array<Filter>
     */
    public function getFilters(): array
    {
        return [];
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
                ->showLabel(),

            // Action::make('delete', 'Elimina')
            //     ->icon('pi pi-trash')
            //     ->put()
            //     ->color(Color::Danger)
            //     ->requiresConfirmation()
            //     ->showLabel()
            //     ->url(avidRoute('projects.bulk.destroy')),
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
                ->url(fn (Model $record) => avidRoute('projects.edit', $record)),

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
        return avidRoute('projects.edit', $record);
    }
}