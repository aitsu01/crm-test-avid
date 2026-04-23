<?php

namespace App\Forms;

use Ingenia\Avid\Forms\Components\Field;
use Ingenia\Avid\Forms\Components\Select;
use Ingenia\Avid\Forms\Components\Text;
use Ingenia\Avid\Forms\Form;
use Ingenia\Avid\Forms\Layouts\Grid;
use Ingenia\Avid\Forms\Layouts\Layout;
use Ingenia\Avid\Forms\Layouts\Section;

class UserForm extends Form
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
                            Text::make('email', 'Email')->required(),

                            Select::make('role', 'Ruolo')
                                ->required()
                                ->options([
                                    ['label' => 'Admin', 'key' => 'admin'],
                                    ['label' => 'Utente', 'key' => 'user'],
                                ]),
                        ]),
                ]),
        ];
    }
}