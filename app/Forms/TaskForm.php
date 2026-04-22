<?php

namespace App\Forms;

use App\Models\Project;
use Ingenia\Avid\Forms\Components\Date;
use Ingenia\Avid\Forms\Components\Field;
use Ingenia\Avid\Forms\Components\Select;
use Ingenia\Avid\Forms\Components\Text;
use Ingenia\Avid\Forms\Form;
use Ingenia\Avid\Forms\Layouts\Grid;
use Ingenia\Avid\Forms\Layouts\Layout;
use Ingenia\Avid\Forms\Layouts\Section;

class TaskForm extends Form
{
    /**
     * @return array<Field | Layout>
     */
    public function getSchema(): array
    {
        return [
            Section::make()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Text::make('name', 'Nome')->required(),
                            Text::make('description', 'Descrizione')->required(),

                            Select::make('project_id', 'Progetto')
                                ->required()
                                ->options(
                                    Project::query()
                                        ->orderBy('name')
                                        ->get()
                                        ->map(fn (Project $project) => [
                                            'label' => $project->name,
                                            'key' => $project->id,
                                        ])
                                        ->values()
                                        ->toArray()
                                ),

                            Select::make('status', 'Stato')
                                ->required()
                                ->options([
                                    ['label' => 'Da fare', 'key' => 'todo'],
                                    ['label' => 'In corso', 'key' => 'in_progress'],
                                    ['label' => 'Completata', 'key' => 'done'],
                                ]),

                            Select::make('priority', 'Priorità')
                                ->required()
                                ->options([
                                    ['label' => 'Bassa', 'key' => 'low'],
                                    ['label' => 'Media', 'key' => 'medium'],
                                    ['label' => 'Alta', 'key' => 'high'],
                                ]),

                            Date::make('due_date', 'Scadenza'),
                        ]),
                ]),
        ];
    }
}