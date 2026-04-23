<?php

namespace App\Http\Controllers;

use App\Forms\TaskForm;
use App\Http\Requests\Task\BulkDestroyTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Tables\TaskTable;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        return Inertia::render('avid/default/Table')
                ->title(__('resources.task.index'))
                ->breadcrumb(__('resources.task.index'))
                ->size('md')
                ->table(TaskTable::make());
    }

    public function create()
    {
        return Inertia::render('avid/default/FormModal')
                ->title(__('resources.task.create'))
                ->breadcrumb(__('resources.task.index'), avidRoute('tasks.index'))
                ->breadcrumb(__('resources.task.create'))
                ->size('md')
                ->form(
                    TaskForm::make()
                        ->submit(avidRoute('tasks.store'))
                        ->cancel(avidRoute('tasks.index'))
                        ->post()
                );
    }

    public function store(StoreTaskRequest $request)
    {
        Task::create($request->validated());

        return redirect(avidRoute('tasks.index'))->success(__('resources.task.store'));
    }

    public function show(Task $task)
    {
        //
    }

    public function edit(Task $task)
    {
        return Inertia::render('avid/default/FormModal')
                ->title(__('resources.task.edit'))
                ->breadcrumb(__('resources.task.index'), avidRoute('tasks.index'))
                ->breadcrumb(__('resources.task.edit'))
                ->size('md')
                ->form(
                    TaskForm::make()
                        ->submit(avidRoute('tasks.update', $task))
                        ->cancel(avidRoute('tasks.index'))
                        ->defaultData($task)
                        ->put()
                );
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect(avidRoute('tasks.index'))->success(__('resources.task.update'));
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return back()->success(__('resources.task.destroy'));
    }

    public function bulkDestroy(BulkDestroyTaskRequest $request)
    {
        Task::query()
            ->whereIn('id', $request->validated('selection'))
            ->get()
            ->each(fn (Task $task) => $task->delete());

        return back()->success(__('resources.task.bulk_destroy'));
    }
}