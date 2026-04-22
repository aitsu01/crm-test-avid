<?php

namespace App\Http\Controllers;

use App\Forms\ProjectForm;
use App\Http\Requests\Project\BulkDestroyProjectRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Tables\ProjectTable;
use Inertia\Inertia;
use App\Notifications\ProjectCreatedNotification;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Notifications\ProjectDeletedNotification;
use App\Notifications\ProjectsBulkDeletedNotification;





class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('avid/default/Table')
                ->title(__('resources.project.index'))
                ->breadcrumb(__('resources.project.index'))
                ->size('md')
                ->table(ProjectTable::make());
    }

    public function create()
{
    return Inertia::render('avid/default/Form')
            ->title(__('resources.project.create'))
            ->breadcrumb(__('resources.project.index'), avidRoute('projects.index'))
            ->breadcrumb(__('resources.project.create'))
            ->size('md')
            ->form(
                ProjectForm::make()
                    ->submit(avidRoute('projects.store'))
                    ->cancel(avidRoute('projects.index'))
                    ->post()
            );
}
    /*public function store(StoreProjectRequest $request)
    {
        Project::create($request->validated());

        return redirect(avidRoute('projects.index'))->success(__('resources.project.store'));
    }*/
public function store(StoreProjectRequest $request)
{
    $project = Project::create($request->validated());

    $createdBy = Auth::user()?->name ?? 'Utente sconosciuto';

    $users = User::query()
        ->where('id', '!=', Auth::id())
        ->get();

    foreach ($users as $user) {
        $user->notify(new ProjectCreatedNotification($project->name, $createdBy));
    }

    return redirect(avidRoute('projects.index'))->success(__('resources.project.store'));
}

    public function show(Project $project)
    {
        //
    }

    public function edit(Project $project)
    {
        return Inertia::render('avid/default/Form')
                ->title(__('resources.project.edit'))
                ->breadcrumb(__('resources.project.index'), avidRoute('projects.index'))
                ->breadcrumb(__('resources.project.edit'))
                ->size('md')
                ->form(
                    ProjectForm::make()
                        ->submit(avidRoute('projects.update', $project))
                        ->cancel(avidRoute('projects.index'))
                        ->defaultData($project)
                        ->put()
                );
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect(avidRoute('projects.index'))->success(__('resources.project.update'));
    }

  public function destroy(Project $project)
{
    $projectName = $project->name;
    $deletedBy = Auth::user()?->name ?? 'Utente sconosciuto';

    $project->delete();

    $users = User::query()
        ->where('id', '!=', Auth::id())
        ->get();

    foreach ($users as $user) {
        $user->notify(new ProjectDeletedNotification($projectName, $deletedBy));
    }

    return back()->success(__('resources.project.destroy'));
}
public function bulkDestroy(BulkDestroyProjectRequest $request)
{
    $projects = Project::query()
        ->whereIn('id', $request->validated('selection'))
        ->get();

    $projectNames = $projects->pluck('name')->toArray();
    $deletedBy = Auth::user()?->name ?? 'Utente sconosciuto';

    $projects->each(fn (Project $project) => $project->delete());

    $users = User::query()
        ->where('id', '!=', Auth::id())
        ->get();

    foreach ($users as $user) {
        $user->notify(new ProjectsBulkDeletedNotification($projectNames, $deletedBy));
    }

    return back()->success(__('resources.project.bulk_destroy'));
}
   

}