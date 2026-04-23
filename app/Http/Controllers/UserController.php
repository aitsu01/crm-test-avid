<?php

namespace App\Http\Controllers;

use App\Forms\UserForm;
use App\Http\Requests\User\BulkDestroyUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Tables\UserTable;
use Inertia\Inertia;


class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('avid/default/Table')
                ->title(__('resources.user.index'))
                ->breadcrumb(__('resources.user.index'))
                ->size('md')
                ->table(UserTable::make());
    }

    public function create()
{
    return Inertia::render('avid/default/FormModal')
            ->title(__('resources.user.create'))
            ->breadcrumb(__('resources.user.index'), avidRoute('users.index'))
            ->breadcrumb(__('resources.user.create'))
            ->size('md')
            ->form(
                UserForm::make()
                    ->submit(avidRoute('users.store'))
                    ->cancel(avidRoute('users.index'))
                    ->post()
            );
}

    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());

        return redirect(avidRoute('users.index'))->success(__('resources.user.store'));
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
{
    return Inertia::render('avid/default/FormModal')
            ->title(__('resources.user.edit'))
            ->breadcrumb(__('resources.user.index'), avidRoute('users.index'))
            ->breadcrumb(__('resources.user.edit'))
            ->size('md')
            ->form(
                UserForm::make()
                    ->submit(avidRoute('users.update', $user))
                    ->cancel(avidRoute('users.index'))
                    ->defaultData($user)
                    ->put()
            );
}

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect(avidRoute('users.index'))->success(__('resources.user.update'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->success(__('resources.user.destroy'));
    }

    public function bulkDestroy(BulkDestroyUserRequest $request)
    {
        User::query()
            ->whereIn('id', $request->validated('selection'))
            ->get()
            ->each(fn (User $user) => $user->delete());

        return back()->success(__('resources.user.bulk_destroy'));
    }
}