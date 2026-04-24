<?php

namespace App\Forms;

use Ingenia\Avid\Forms\Components\Field;
use Ingenia\Avid\Forms\Components\Text;
use Ingenia\Avid\Forms\Form;
use Ingenia\Avid\Forms\Layouts\Grid;
use Ingenia\Avid\Forms\Layouts\Layout;
use Ingenia\Avid\Forms\Layouts\Section;

class ProjectForm extends Form
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
                            Text::make('description', 'Descrizione'),
                        ]),
                ]),
        ];
    }
}