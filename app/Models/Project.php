<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ingenia\Avid\Contracts\Optionable;
use Ingenia\Avid\Traits\AsOptions;

#[Fillable(['name', 'description'])]
class Project extends Model implements Optionable
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;
    use AsOptions;

    public function tasks(): HasMany
{
    return $this->hasMany(Task::class);
}


}