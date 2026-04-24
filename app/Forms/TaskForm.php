<?php

namespace App\Forms;

use App\Enums\Priority;
use App\Enums\TaskStatus;
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
                    Grid::make(3)
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
                                ->options(TaskStatus::asOptions()),

                            Select::make('priority', 'Priorità')
                                ->required()
                                ->options(Priority::asOptions()),

                            Date::make('due_date', 'Scadenza'),
                        ]),
                ]),
        ];
    }
}